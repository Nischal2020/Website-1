<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Material;
use App\Http\Responses\CustomJsonResponse;

class MaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return Material::all();
    }

    private function fetchMaterial($id){
        $material = Material::where('id', $id)->get()->first();
        if($material != NULL){
            return $material;
        }
        return NULL;
    }

    public function getMaterial($id){
        $material = $this->fetchMaterial($id);
        if($material == NULL){
            return new CustomJsonResponse(false,"Material not found", 404);
        }
        return new CustomJsonResponse(true, $material, 200);
    }

    public function putMaterial(Request $request, $id){
        $input = $request->except('_token');
        $validator = $this->getValidator($input, $id);
        if($validator->passes()) {
            $material = $this->fetchMaterial($id);
            if($material == NULL) {
                return new CustomJsonResponse(false,"Material not found", 404);
            }

            if(isset($input['description']))
                $material->description = $input['description'];

            $material->save();
            return new CustomJsonResponse(true, $material, 200);
        }  else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function postMaterial(Request $request){

        $input = $request->except('_token');
        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $material = new Material();
            $material->description = $request->description;
            $material->save();
            return new CustomJsonResponse(true, $material, 200);
        } else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function deleteMaterial(Request $request, $id){
        $material = $this->fetchMaterial($id);
        if($material == NULL) {
            return new CustomJsonResponse(false,"Material not found", 404);
        }
        $material->delete();
        return new CustomJsonResponse(true, "Material successfully deleted", 200);
    }

    private function getValidator($input, $id)
    {
        if($id == NULL) { //post (creation)
            $validationArray = [
                'description' => 'required|string',
            ];
        } else { //put (update)
            $validationArray = [
                'description' => 'string', //If more columns are added to roles (thus to this validation) remove required here
            ];
        }

        $validator = \Validator::make($input, $validationArray);
        return $validator;
    }

}
