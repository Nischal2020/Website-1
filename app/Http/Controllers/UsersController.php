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
        $idPossibilities = array("student_id", "email");

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
    public function postUser(Request $request, $identification)
    {
        $input = $request->except('_token');
        // TODO: Falta verificar as permissoes do user para editar este objeto (se admin ou utilizador)
        $user = $this->getUser($identification);
        if($user == NULL) {
            \App::abort(404);
            return NULL;
        }
        $user->update($input);
    }

    /*
     * Regista utilizador na base de dados
     */
    public function putUser(Request $request)
    {
        $input = $request->except('_token');
        if($this->putValidation($input)) {
            $user = User::create([
                "username" => $input['username'],
                "password" => Hash::make($input['password']),
                "student_id" => $input['student_id'],
                "email" => $input['email']
            ]);
            Auth::login($user); // Login the new user.
            return redirect('home')->with('message', 'Bem vindo ao Clube de Programação!'); // return to web.app/home with success message
        }
        // user didn't validate, return to old page.

        return Redirect::back()->with('error', 'Algo de errado aconteceu.')->withErrors(); // error message bag.
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
    private function putValidation($input)
    {
        $validationarray = [
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'student_id' => ["required", "Regex:/^(uc|a)([0-9]{10})$/"], // obriga a que todos os números sejam uc201xxxxxxx ou a201xxxxxxx
            'password' => 'required|confirmed', // o "confirmed" necessita de um text input com o nome de password_confirmation, para verificar se a password é igual nos dois sítios.
        ];
        $validator = Validator::make($input, $validationarray);
        return $validator->passes();
    }
}
