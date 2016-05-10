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

        $organization->update($input);
    }

    public function postOrganization(Request $request){
        
        $organization = new Organization;
        $organization->designation = $request->designation;
        $organization->save();        
        
    }

    public function deleteOrganization(Request $request, $id){
        $organization = $this->getOrganization($id);
        if($organization == NULL) {
            \App::abort(404);
            return NULL;
        }
        $organization->delete();
    }

}
