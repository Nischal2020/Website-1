<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Organization;
use App\Http\Responses\CustomJsonResponse;

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

    private function fetchOrganization($id){
        $organization = Organization::where('id', $id)->get()->first();
        if($organization != NULL){
            return $organization;
        }
        return NULL;
    }

    public function getOrganization($id){
        $organization = $this->fetchOrganization($id);
        if($organization == NULL){
            return new CustomJsonResponse(false,"Organization not found", 404);
        }
        return new CustomJsonResponse(true, $organization, 200);
    }

    public function putOrganization(Request $request, $id){
        $input = $request->except('_token');
        $validator = $this->getValidator($input, $id);
        if($validator->passes()) {
            $organization = $this->fetchOrganization($id);
            if($organization == NULL) {
                return new CustomJsonResponse(false,"Organization not found", 404);
            }

            if(isset($input['name']))
                $organization->name = $input['name'];

            if(isset($input['website']))
                $organization->website = $input['website'];

            if(isset($input['logo']))
                $organization->logo = $input['logo'];

            if(isset($input['intradepartment']))
                $organization->intradepartment = $input['intradepartment'];

            $organization->save();
            return new CustomJsonResponse(true, $organization, 200);
        }  else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function postOrganization(Request $request){
        $input = $request->except('_token');
        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $organization = new Organization();
            //Required data
            $organization->name = $request->name;
            $organization->intradepartment = $request->intradepartment;

            //Optional data
            if(isset($input['website']))
                $organization->website = $input['website'];

            if(isset($input['logo']))
                $organization->logo = $input['logo'];

            $organization->save();
            return new CustomJsonResponse(true, $organization, 200);
        } else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        
    }

    public function deleteOrganization(Request $request, $id){
        $organization = $this->fetchOrganization($id);
        if($organization == NULL) {
            return new CustomJsonResponse(false,"Organization not found", 404);
        }
        $organization->delete();
        return new CustomJsonResponse(true, "Organization successfully deleted", 200);

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
