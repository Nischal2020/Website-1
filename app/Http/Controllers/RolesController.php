<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Role;
use App\Http\Responses\CustomJsonResponse;

class RolesController extends Controller
{

    public function getAll()
    {
        return Role::all();
    }

    private function fetchRole($id){
        $role = Role::where('id', $id)->get()->first();
        if($role != NULL){
            return $role;
        }
        return NULL;
    }

    public function getRole($id){
        $role = $this->fetchRole($id);
        if($role == NULL){
            return new CustomJsonResponse(false,"Role not found", 404);
        }
        return new CustomJsonResponse(true, $role, 200);

    }

    public function putRole(Request $request, $id){
    	$input = $request->except('_token');
        $validator = $this->getValidator($input, $id);
        if($validator->passes()) {
            $role = $this->fetchRole($id);
            if($role == NULL) {
                return new CustomJsonResponse(false,"Role not found", 404);
            }

            if(isset($input['designation']))
                $role->designation = $input['designation'];

            $role->save();
            return new CustomJsonResponse(true, $role, 200);
        }  else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function postRole(Request $request){
        $input = $request->except('_token');
        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $role = new Role;
            $role->designation = $request->designation;
            $role->save();
            return new CustomJsonResponse(true, $role, 200);
        } else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function deleteRole(Request $request, $id){
        $role = $this->fetchRole($id);
        if($role == NULL) {
            return new CustomJsonResponse(false,"Role not found", 404);
        }
        $role->delete();
        return new CustomJsonResponse(true, "Role successfully deleted", 200);
    }

    private function getValidator($input, $id)
    {
        if($id == NULL) { //post (creation)
            $validationArray = [
                'designation' => 'required|string',
            ];
        } else { //put (update)
            $validationArray = [
                'designation' => 'required|string', //If more columns are added to roles (thus to this validation) remove required here
            ];
        }

        $validator = \Validator::make($input, $validationArray);
        return $validator;
    }

}
