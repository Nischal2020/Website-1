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
        //$identification may be username, student_id or email
        $idPossibilities = array("username", "student_id", "email");

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
        $user = fetchUser($identification);

        if(!$user){
            //If it reaches here, user doesn't exist
            return new CustomJsonResponse(false,"User not found", 404);
        }

        return NULL;
    }
    /*
     * Atualiza utilizador
     */
    public function putUser(Request $request, $identification)
    {
        $input = $request->except('_token');
        // TODO: Falta verificar as permissoes do user para editar este objeto (se admin ou utilizador)
        $user = $this->fetchUser($identification);
        if($user == NULL) {
            return new CustomJsonResponse(false,"User not found", 404);
        }
        
        $validator = $this->getValidator($input, $identification);
        if($validator->passes()) {
            $user->update($input);
            return $user;
        } else {
            return $validator->errors()->getMessages();
        }


        \App::abort(404);
        return NULL;
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
                "password" => Hash::make($input['password']),
                "student_id" => $input['student_id'],
                "email" => $input['email']
            ]);
            return $user;
        } else {
            return $validator->errors()->getMessages();
        }


        \App::abort(404);
        return NULL;
    }


    public function deleteUser(Request $request, $identification)
    {
        // TODO: Falta verificar as permissoes do user para editar este objeto (se admin ou utilizador)
        $user = $this->getUser($identification);
        if($user == NULL) {
            \App::abort(404);
            return NULL;
        }
        $user->delete();
        return ['message', 'success']; // TODO: change this return.
    }
    /*
     * Valida as informações vindas do utilizador
     * DOCS: https://laravel.com/docs/5.2/validation
     *
     * TODO: Validator errors
     */
    private function getValidator($input, $id)
    {
        if($id == NULL) { //post (creation)
            $validationArray = [
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'student_id' => ["required|unique:users", "Regex:/^([0-9]{10})$/"], // obriga a que todos os números sejam uc201xxxxxxx ou a201xxxxxxx
                'password' => 'required|confirmed', // o "confirmed" necessita de um text input com o nome de password_confirmation, para verificar se a password é igual nos dois sítios.
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
                'version_control' => 'url',
                'avatar' => 'url'
            ];
        }

        $validator = \Validator::make($input, $validationArray);
        return $validator;
    }
}
