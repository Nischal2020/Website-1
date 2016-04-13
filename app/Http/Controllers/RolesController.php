<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Role

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return Role::all();
    }

    public function getRole($id){
    	$role = Role::where('id', $id)->get();
    	if($role != NULL){
    		return $role;
    	}
    	 if($role == NULL) {
            \App::abort(404);
            return NULL;
        }
    }

    public function postRole(Request $request, $id){
    	$input = $request->except('_token');
    	$role = $this.getRole($id);
    	if($role == NULL) {
            \App::abort(404);
            return NULL;
        }

        $role->update($input);
    }

}
