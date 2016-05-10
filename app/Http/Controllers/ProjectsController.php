<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Project;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return Project::all();
    }

    public function getProject($id){
        $project = Project::where('id', $id)->get()->first();
        if($project != NULL){
            return $project;
        }
        \App::abort(404);
        return NULL;
    }

    public function putProject(Request $request, $id){
        $input = $request->except('_token');
        $project = $this->getProject($id);
        if($project == NULL) {
            \App::abort(404);
            return NULL;
        }

        $project->update($input);
    }

    public function postProject(Request $request){
        
        $project = new Project;
        $project->designation = $request->designation;
        $project->save();        
        
    }

    public function deleteProject(Request $request, $id){
        $project = $this->getProject($id);
        if($project == NULL) {
            \App::abort(404);
            return NULL;
        }
        $project->delete();
    }

}
