<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Course;
use App\Http\Responses\CustomJsonResponse;

class CoursesController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return Course::all();
    }

    private function fetchCourse($identification){
        //$identification may be id, username, student_id or email
        $idPossibilities = array("id", "name", "initials");

        foreach($idPossibilities as $id){
            $course = Course::where($id, $identification)->get()->first();
            if($course != NULL){
                return $course;
            }
        }
        return NULL;
    }

    public function getCourse($id){
        $course = $this->fetchCourse($id);
        if($course == NULL){
            return new CustomJsonResponse(false,"Course not found", 404);
        }
        return new CustomJsonResponse(true, $course, 200);
        
    }

    public function putCourse(Request $request, $id){
        $input = $request->except('_token');
        $validator = $this->getValidator($input, $id);
        if($validator->passes()) {
            $course = $this->fetchCourse($id);
            if($course == NULL) {
                return new CustomJsonResponse(false,"Course not found", 404);
            }

            if(isset($input['name']))
                $course->name = $input['name'];

            if(isset($input['initials']))
                $course->initials = $input['initials'];

            $course->save();
            return new CustomJsonResponse(true, $course, 200);
        }  else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function postCourse(Request $request){

        $input = $request->except('_token');
        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $course = new Course;
            $course->name = $request->name;
            $course->initials = $request->initials;
            $course->save();
            return new CustomJsonResponse(true, $course, 200);
        } else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function deleteCourse(Request $request, $id){
        $course = $this->fetchCourse($id);
        if($course == NULL) {
            return new CustomJsonResponse(false,"Course not found", 404);
        }
        $course->delete();
        return new CustomJsonResponse(true, "Course successfully deleted", 200);
    }

    /*
     * Valida as informações vindas do curso
     * DOCS: https://laravel.com/docs/5.2/validation
     */
    private function getValidator($input, $id)
    {
        if($id == NULL) { //post (creation)
            $validationArray = [
                'name' => 'required|unique:courses',
                'initials' => 'required|unique:courses'
            ];
        } else { //put (update)
            $validationArray = [
                'name' => 'unique:courses',
                'initials' => 'unique:courses'
            ];
        }

        $validator = \Validator::make($input, $validationArray);
        return $validator;
    }
}

