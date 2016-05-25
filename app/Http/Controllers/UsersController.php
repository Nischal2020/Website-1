<?php namespace App\Http\Controllers;

// TODO: need to change all the redirects, they need to be done client-side.
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
        return new CustomJsonResponse(true, $user, 200);
    }
    /*
     * Atualiza utilizador
     * TODO: Falta verificar as permissoes do user para editar este objeto (se admin ou utilizador)
     */
    public function putUser(Request $request, $identification)
    {
        $input = $request->except('_token');

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
        $input = $request->except('_token');
        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $user = User::create([
                "username" => $input['username'],
                "password" => bcrypt($input['password']),
                "student_id" => $input['student_id'],
                "course_id" => $input['course_id'],
                "email" => $input['email']
            ]);
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
                'course_id' => 'required|exists:courses,id',
                'name' => 'required',
                'version_control' => 'url',
                'avatar' => 'url'
            ];
        } else { //put (update)
            $validationArray = [
                'username' => 'unique:users',
                'email' => 'email|unique:users',
                'student_id' => ["unique:users", "Regex:/^([0-9]{10})$/"], // obriga a que todos os números sejam uc201xxxxxxx ou a201xxxxxxx
                'password' => 'confirmed', // o "confirmed" necessita de um text input com o nome de password_confirmation, para verificar se a password é igual nos dois sítios.
		'course_id' => 'exists:courses,id',
                'version_control' => 'url',
                'avatar' => 'url'
            ];
        }

        $validator = \Validator::make($input, $validationArray);
        return $validator;
    }
}
