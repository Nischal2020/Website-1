<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Course;

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

    //            $table->string('name')->unique();
    //        $table->string('initials')->unique();

    public function getCourse($id){
    	$course = Course::where('id', $id)->get()->first();
    	if($course != NULL){
    		return $course;
    	}
    	
        \App::abort(404);
        return NULL;
        
    }

    public function putCourse(Request $request, $id){
    	$input = $request->except('_token');
    	$course = $this->getCourse($id);
    	if($course == NULL) {
            \App::abort(404);
            return NULL;
        }

        $course->update($input);

        $validator = $this->getValidator($input, $id);
        if($validator->passes()) {
            $user->update($input);
            return $user;
        } else {
            return $validator->errors()->getMessages();
        }
    }

    public function postCourse(Request $request){
        
        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $course = new Course;
            $course->name = $request->name;
            $course->initials = $request->initials;
            $course->save();
            ]);
            return $course;
        } else {
            return $validator->errors()->getMessages();
        }       
    }

    public function deleteCourse(Request $request, $id){
        $course = $this->getCourse($id);
        if($course == NULL) {
            \App::abort(404);
            return NULL;
        }
        $course->delete();
        return ['message', 'success']; // TODO: change this return.
    }

    /*
     * Valida as informações vindas do curso
     * DOCS: https://laravel.com/docs/5.2/validation
     *
     * TODO: Validator errors
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

