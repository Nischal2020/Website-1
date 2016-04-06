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

    public function getUser($username)
    {
        $user = User::where('username', $username)->get();
        if($user == NULL) {
            \App::abort(404);
            return 404;
        }
        return $user;
    }

    public function postUser(Request $request, $username)
    {
        $input = $request->except('_token');
        // TODO: Falta verificar as permissoes do user para editar este objeto (se admin ou utilizador)
        $user = User::where('username', $username)->get();
        if($user == NULL) {
            \App::abort(404);
            return 404;
        }
        $user->update($input);


    }
}
