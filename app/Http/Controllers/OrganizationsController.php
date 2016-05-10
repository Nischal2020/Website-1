<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Organization;

class OrganizationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return Organization::all();
    }

    public function getOrganization($id){
        $organization = Organization::where('id', $id)->get()->first();
        if($organization != NULL){
            return $organization;
        }
        \App::abort(404);
        return NULL;
    }

    public function putOrganization(Request $request, $id){
        $input = $request->except('_token');
        $organization = $this->getOrganization($id);
        if($organization == NULL) {
            \App::abort(404);
            return NULL;
        }

        $validator = $this->getValidator($input, $id);
        if($validator->passes()) {
            $organization->update($input);
            return $organization;
        } else {
            return $validator->errors()->getMessages();
        }
    }

    public function postOrganization(Request $request){
        $input = $request->except('_token');
        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $organization = new Organization;
            $organization->designation = $request->designation;
            $organization->save();
            return $organization;
        } else {
            return $validator->errors()->getMessages();
        }

        
    }

    public function deleteOrganization(Request $request, $id){
        $organization = $this->getOrganization($id);
        if($organization == NULL) {
            \App::abort(404);
            return NULL;
        }
        $organization->delete();
    }

    private function getValidator($input, $id)
    {
        if($id == NULL) { //post (creation)
            $validationArray = [
                'name' => 'required|unique:organizations',
                'website' => 'url|unique:organizations',
                'logo' => 'url',
                'intradepartment' => 'required|boolean'
            ];
        } else { //put (update)
            $validationArray = [
                'name' => 'unique:organizations',
                'website' => 'url|unique:organizations',
                'logo' => 'url',
                'intradepartment' => 'boolean'
            ];
        }

        $validator = \Validator::make($input, $validationArray);
        return $validator;
    }

}
