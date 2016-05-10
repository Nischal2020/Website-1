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
    }

    public function postCourse(Request $request){
        
        $course = new Course;
        $course->name = $request->name;
        $course->initials = $request->initials;
        $course->save();        
    }

    public function deleteCourse(Request $request, $id){
        $course = $this->getCourse($id);
        if($course == NULL) {
            \App::abort(404);
            return NULL;
        }
        $course->delete();
    }
}
