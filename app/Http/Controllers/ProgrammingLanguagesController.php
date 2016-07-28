<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ProgrammingLanguage;
use App\Http\Responses\CustomJsonResponse;

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

    private function fetchProgrammingLanguage($id){
        $programmingLanguage = ProgrammingLanguage::where('id', $id)->get()->first();
        if($programmingLanguage != NULL){
            return $programmingLanguage;
        }
        return NULL;
    }

    public function getProgrammingLanguage($id){
        $programmingLanguage = $this->fetchProgrammingLanguage($id);
        if($programmingLanguage == NULL){
            return new CustomJsonResponse(false,"Programming Language not found", 404);
        }
        return new CustomJsonResponse(true, $programmingLanguage, 200);
    }

    public function putProgrammingLanguage(Request $request, $id){
        $input = $request->all();
        $validator = $this->getValidator($input, $id);
        if($validator->passes()) {
            $programmingLanguage = $this->fetchProgrammingLanguage($id);
            if($programmingLanguage == NULL) {
                return new CustomJsonResponse(false,"Programming Language not found", 404);
            }

            if(isset($input['designation']))
                $programmingLanguage->designation = $input['designation'];

            if(isset($input['description']))
                $programmingLanguage->designation = $input['description'];

            $programmingLanguage->save();
            return new CustomJsonResponse(true, $programmingLanguage, 200);
        }  else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function postProgrammingLanguage(Request $request){
        $input = $request->all();
        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $programmingLanguage = new ProgrammingLanguage;
            //Required data
            $programmingLanguage->designation = $request->designation;
            //Optional data
            if(isset($input['description']))
                $programmingLanguage->designation = $input['description'];

            $programmingLanguage->save();
            return new CustomJsonResponse(true, $programmingLanguage, 200);
        } else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function deleteProgrammingLanguage(Request $request, $id){
        $programmingLanguage = $this->fetchProgrammingLanguage($id);
        if($programmingLanguage == NULL) {
            return new CustomJsonResponse(false,"Programming Language not found", 404);
        }
        $programmingLanguage->delete();
        return new CustomJsonResponse(true, "Programming Language successfully deleted", 200);
    }

    private function getValidator($input, $id)
    {
        if($id == NULL) { //post (creation)
            $validationArray = [
                'designation' => 'required|string',
                'description' => 'string'
            ];
        } else { //put (update)
            $validationArray = [
                'designation' => 'string',
                'description' => 'string'
            ];
        }

        $validator = \Validator::make($input, $validationArray);
        return $validator;
    }

}
