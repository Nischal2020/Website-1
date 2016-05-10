<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ProgrammingLanguage;

class ProgrammingLanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return ProgrammingLanguage::all();
    }

    public function getProgrammingLanguage($id){
        $programming_language = ProgrammingLanguage::where('id', $id)->get()->first();
        if($programming_language != NULL){
            return $programming_language;
        }
        \App::abort(404);
        return NULL;
    }

    public function putProgrammingLanguage(Request $request, $id){
        $input = $request->except('_token');
        $programming_language = $this->getProgrammingLanguage($id);
        if($programming_language == NULL) {
            \App::abort(404);
            return NULL;
        }

        $programming_language->update($input);
    }

    public function postProgrammingLanguage(Request $request){
        
        $programming_language = new ProgrammingLanguage;
        $programming_language->designation = $request->designation;
        $programming_language->save();        
        
    }

    public function deleteProgrammingLanguage(Request $request, $id){
        $programming_language = $this->getProgrammingLanguage($id);
        if($programming_language == NULL) {
            \App::abort(404);
            return NULL;
        }
        $programming_language->delete();
    }

}
