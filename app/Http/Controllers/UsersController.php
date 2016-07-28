<?php namespace App\Http\Controllers;

// TODO: need to change all the redirects, they need to be done client-side.
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Http\Responses\CustomJsonResponse;

class UsersController extends Controller
{
    public function getAll()
    {
        // A usar Eloquent functions
        return User::all();
    }

    /*
     * Obtem dados sobre utilizador
     */
    private function fetchUser($identification){
        //$identification may be id, username, student_id or email
        $idPossibilities = array("id", "username", "student_id", "email");

        foreach($idPossibilities as $id){
            $user = User::where($id, $identification)->get()->first();
            if($user != NULL){
                return $user;
            }
        }
        return NULL;
    }

    public function getUser($identification)
    {   
        $user = $this->fetchUser($identification);

        if($user == NULL){ //If it reaches here, user doesn't exist
            return new CustomJsonResponse(false,"User not found", 404);
        }
        $user->load('events');
        $user->load('projects');
        $user->load('organizations');
        $user->load('programmingLanguages');

        return new CustomJsonResponse(true, $user, 200);
    }
    /*
     * Atualiza utilizador
     * TODO: Falta verificar as permissoes do user para editar este objeto (se admin ou utilizador)
     */
    public function putUser(Request $request, $identification)
    {
        $input = $request->all();

        $validator = $this->getValidator($input, $identification);
        if($validator->passes()) {
            $user = $this->fetchUser($identification);
            if($user == NULL) {
                return new CustomJsonResponse(false,"User not found", 404);
            }
            $user->update($input);
            return new CustomJsonResponse(true, $user, 200);
        } else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    /*
     * Regista utilizador na base de dados
     */
    public function postUser(Request $request)
    {
        $input = $request->all();

        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $dataArray = array(
                "username" => $input['username'],
                "password" => bcrypt($input['password']),
                "student_id" => $input['student_id'],
                "email" => $input['email']
            );

            if(isset($input['course_id']))
                $dataArray = array_add($dataArray, 'course_id', $input['course_id']);

            if(isset($input['name']))
                $dataArray = array_add($dataArray, 'name', $input['name']);

            if(isset($input['avatar']))
                $dataArray = array_add($dataArray, 'avatar', $input['avatar']);

            if(isset($input['version_control']))
                $dataArray = array_add($dataArray, 'version_control', $input['version_control']);

            if(isset($input['about']))
                $dataArray = array_add($dataArray, 'about', $input['about']);


            $user = User::create($dataArray);
            return new CustomJsonResponse(true, $user, 200);
        } else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }
        
        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }


    public function deleteUser(Request $request, $identification)
    {
        // TODO: Falta verificar as permissoes do user para editar este objeto (se admin ou utilizador)
        $user = $this->getUser($identification);
        if($user == NULL) {
            return new CustomJsonResponse(false,"User not found", 404);
        }
        $user->delete();
        return new CustomJsonResponse(true, "User successfully deleted", 200);
    }
    /*
     * Valida as informações vindas do utilizador
     * DOCS: https://laravel.com/docs/5.2/validation
     */
    private function getValidator($input, $id)
    {
        if($id == NULL) { //post (creation)
            $validationArray = [
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'student_id' => "required|digits:10|unique:users",
                'password' => 'required|confirmed', // o "confirmed" necessita de um text input com o nome de password_confirmation, para verificar se a password é igual nos dois sítios.
                'course_id' => 'exists:courses,id',
                'role_id' => 'exists:roles,id',
                'name' => 'required',
                'version_control' => 'url',
                'avatar' => 'url',
                'role_id' => 'exists:roles,id',
            ];
        } else { //put (update)
            $validationArray = [
                'username' => 'unique:users',
                'email' => 'email|unique:users',
                'student_id' => ["unique:users", "digits:10"], 
                'password' => 'confirmed', // o "confirmed" necessita de um text input com o nome de password_confirmation, para verificar se a password é igual nos dois sítios.
		        'course_id' => 'exists:courses,id',
                'role_id' => 'exists:roles,id',
                'version_control' => 'url',
                'avatar' => 'url',
                'role_id' => 'exists:roles,id',
            ];
        }

        $validator = \Validator::make($input, $validationArray);
        return $validator;
    }

    public function postEvent(Request $request, $identification, $event_id) {
        $user = $this->fetchUser($identification);

        if($user == NULL){ //If it reaches here, user doesn't exist
            return new CustomJsonResponse(false,"User not found", 404);
        }

        if(\Validator::make(['event_id' => $event_id], ['event_id' => 'exists:events,id'])->passes()) {
            if(!$user->events->contains($event_id)) { //event already exists
                $user->events()->attach($event_id);
                $user->load('events'); //Refreshes the model
            }
            return new CustomJsonResponse(true, $user, 200);
        }
        return new CustomJsonResponse(false, "Event does not exist", 404);
    }

    public function deleteEvent(Request $request, $identification, $event_id) {
        $user = $this->fetchUser($identification);

        if($user == NULL){ //If it reaches here, user doesn't exist
            return new CustomJsonResponse(false,"User not found", 404);
        }

        foreach ($user->events as $event) {
            if($event->id == $event_id) {
                $user->events()->detach($event_id);
                $user->load('events'); //Refreshes the model
                return new CustomJsonResponse(true, $user, 200);
            }
        }
        return new CustomJsonResponse(false, "User isn't participating in this event", 404);
    }

    public function postProject(Request $request, $identification, $project_id) {
        $user = $this->fetchUser($identification);

        if($user == NULL){ //If it reaches here, user doesn't exist
            return new CustomJsonResponse(false,"User not found", 404);
        }

        if(\Validator::make(['project_id' => $project_id], ['project_id' => 'exists:projects,id'])->passes()) {
            if(!$user->projects->contains($project_id)) { //project already exists
                $user->projects()->attach($project_id);
                $user->load('projects'); //Refreshes the model
            }
            return new CustomJsonResponse(true, $user, 200);
        }
        return new CustomJsonResponse(false, "Project does not exist", 404);
    }
    
    public function deleteProject(Request $request, $identification, $project_id) {
        $user = $this->fetchUser($identification);

        if($user == NULL){ //If it reaches here, user doesn't exist
            return new CustomJsonResponse(false,"User not found", 404);
        }

        foreach ($user->projects as $project) {
            if($project->id == $project_id) {
                $user->projects()->detach($project_id);
                $user->load('projects'); //Refreshes the model
                return new CustomJsonResponse(true, $user, 200);
            }
        }
        return new CustomJsonResponse(false, "User isn't member of this project", 404);
    }

    public function postOrganization(Request $request, $identification, $organization_id) {
        $user = $this->fetchUser($identification);

        if($user == NULL){ //If it reaches here, user doesn't exist
            return new CustomJsonResponse(false,"User not found", 404);
        }

        if(\Validator::make(['organization_id' => $organization_id], ['organization_id' => 'exists:organizations,id'])->passes()) {
            if(!$user->organizations->contains($organization_id)) {
                $user->organizations()->attach($organization_id);
                $user->load('organizations'); //Refreshes the model
            }
            return new CustomJsonResponse(true, $user, 200);
        }
        return new CustomJsonResponse(false, "Organization does not exist", 404);
    }

    public function deleteOrganization(Request $request, $identification, $organization_id) {
        $user = $this->fetchUser($identification);

        if($user == NULL){ //If it reaches here, user doesn't exist
            return new CustomJsonResponse(false,"User not found", 404);
        }

        foreach ($user->organizations as $organization) {
            if($organization->id == $organization_id) {
                $user->organizations()->detach($organization_id);
                $user->load('organizations'); //Refreshes the model
                return new CustomJsonResponse(true, $user, 200);
            }
        }
        return new CustomJsonResponse(false, "User isn't member of this organization", 404);
    }

    public function postProgrammingLanguage(Request $request, $identification, $programming_language_id) {
        $user = $this->fetchUser($identification);

        if($user == NULL){ //If it reaches here, user doesn't exist
            return new CustomJsonResponse(false,"User not found", 404);
        }

        if(\Validator::make(['programming_language_id' => $programming_language_id], ['programming_language_id' => 'exists:programming_languages,id'])->passes()) {
            if(!$user->programmingLanguages->contains($programming_language_id)) {
                $user->programmingLanguages()->attach($programming_language_id);
                $user->load('programmingLanguages'); //Refreshes the model
            }
            return new CustomJsonResponse(true, $user, 200);
        }
        return new CustomJsonResponse(false, "Programming Language does not exist", 404);
    }

    public function deleteProgrammingLanguage(Request $request, $identification, $programming_language_id) {
        $user = $this->fetchUser($identification);

        if($user == NULL){ //If it reaches here, user doesn't exist
            return new CustomJsonResponse(false,"User not found", 404);
        }

        foreach ($user->programmingLanguages as $programmingLanguage) {
            if($programmingLanguage->id == $programming_language_id) {
                $user->programmingLanguages()->detach($programming_language_id);
                $user->load('programmingLanguages'); //Refreshes the model
                return new CustomJsonResponse(true, $user, 200);
            }
        }
        return new CustomJsonResponse(false, "User doesn't know this programming language", 404);
    }
}
