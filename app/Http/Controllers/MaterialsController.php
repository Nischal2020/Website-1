<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Material;

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

    public function getMaterial($id){
        $material = Material::where('id', $id)->get()->first();
        if($material != NULL){
            return $material;
        }
        \App::abort(404);
        return NULL;
    }

    public function putMaterial(Request $request, $id){
        $input = $request->except('_token');
        $material = $this->getMaterial($id);
        if($material == NULL) {
            \App::abort(404);
            return NULL;
        }

        $material->update($input);
    }

    public function postMaterial(Request $request){
        
        $material = new Material;
        $material->designation = $request->designation;
        $material->save();        
        
    }

    public function deleteMaterial(Request $request, $id){
        $material = $this->getMaterial($id);
        if($material == NULL) {
            \App::abort(404);
            return NULL;
        }
        $material->delete();
    }

}
