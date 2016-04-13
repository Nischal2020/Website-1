<?php

namespace App\Http\Controllers;

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

    
    public function getUser($identification)
    {   
        //$identification may be username, student_id or email
        $idPossibilities = array("student_id", "email");

        foreach($idPossibilities as $id){
            $user = User::where($id, $identification)->get();
            if($user!=NULL){
                return $user;
            } 
                
        }
        
        //If it reaches here, user doesnt exist
        \App::abort(404);
        return NULL;
        
        
    }

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
}
