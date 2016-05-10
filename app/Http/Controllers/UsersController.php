<?php

namespace App\Http\Controllers;
// TODO: need to change all the redirects, they need to be done client-side.
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

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
    public function getUser($identification)
    {   
        //$identification may be username, student_id or email
        $idPossibilities = array("username", "student_id", "email");

        foreach($idPossibilities as $id){
            $user = User::where($id, $identification)->get()->first();
            if($user != NULL){
                return $user;
            }
        }
        
        //If it reaches here, user doesn't exist
        \App::abort(404);
        return NULL;
        
    }
    /*
     * Atualiza utilizador
     */
    public function putUser(Request $request, $identification)
    {
        $input = $request->except('_token');
        // TODO: Falta verificar as permissoes do user para editar este objeto (se admin ou utilizador)
        $user = $this->getUser($identification);
        if($user == NULL) {
            \App::abort(404);
            return NULL;
        }

        if($this->runValidation($input, $identification)) {
            $user->update($input);
            return $user;
        }

    }

    /*
     * Regista utilizador na base de dados
     */
    public function postUser(Request $request)
    {
        $input = $request->except('_token');
        if($this->runValidation($input, NULL)) {
            $user = User::create([
                "username" => $input['username'],
                "password" => Hash::make($input['password']),
                "student_id" => $input['student_id'],
                "email" => $input['email']
            ]);
            return $user;
        }

        //Validation failed
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
        return ['message', 'sucess']; // TODO: change this return.
    }
    /*
     * Valida as informações vindas do utilizador
     * DOCS: https://laravel.com/docs/5.2/validation
     */
    private function runValidation($input, $id)
    {
        if($id == NULL) { //post (creation)
            $validationarray = [
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'student_id' => ["required|unique:users", "Regex:/^([0-9]{10})$/"], // obriga a que todos os números sejam uc201xxxxxxx ou a201xxxxxxx
                'password' => 'required|confirmed', // o "confirmed" necessita de um text input com o nome de password_confirmation, para verificar se a password é igual nos dois sítios.
                'name' => 'required',
                'version_control' => 'url',
                'avatar' => 'url'
            ];
        } else { //put (update)
            $validationarray = [
                'username' => 'unique:users',
                'email' => 'email|unique:users',
                'student_id' => ["unique:users", "Regex:/^([0-9]{10})$/"], // obriga a que todos os números sejam uc201xxxxxxx ou a201xxxxxxx
                'password' => 'confirmed', // o "confirmed" necessita de um text input com o nome de password_confirmation, para verificar se a password é igual nos dois sítios.
                'version_control' => 'url',
                'avatar' => 'url'
            ];
        }

        $validator = \Validator::make($input, $validationarray);
        return $validator->passes();
    }
}
