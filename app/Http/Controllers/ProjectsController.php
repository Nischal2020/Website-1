<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Project;
use App\Http\Responses\CustomJsonResponse;

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

    private function fetchProject($id){
        $project = Project::where('id', $id)->get()->first();
        if($project != NULL){
            return $project;
        }
        return NULL;
    }

    public function getProject($id){
        $project = $this->fetchProject($id);
        if($project == NULL){
            return new CustomJsonResponse(false,"Project not found", 404);
        }
        return new CustomJsonResponse(true, $project, 200);
    }

    public function putProject(Request $request, $id){
        $input = $request->except('_token');
        $validator = $this->getValidator($input, $id);
        if($validator->passes()) {
            $project = $this->fetchProject($id);
            if($project == NULL) {
                return new CustomJsonResponse(false,"Project not found", 404);
            }

            if(isset($input['name']))
                $project->name = $input['name'];

            if(isset($input['description']))
                $project->description = $input['description'];

            if(isset($input['start_date']))
                $project->start_date = $input['start_date'];

            if(isset($input['end_date']))
                $project->end_date = $input['end_date'];

            if(isset($input['coordenator_id']))
                $project->coordenator_id = $input['coordenator_id'];

            if(isset($input['logo']))
                $project->logo = $input['logo'];

            if(isset($input['version_control']))
                $project->version_control = $input['version_control'];

            $project->save();
            return new CustomJsonResponse(true, $project, 200);
        }  else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function postProject(Request $request){
        $input = $request->except('_token');
        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $project = new Project;
            //Required data
            $project->name = $request->name;
            $project->start_date = $request->start_date;
            $project->version_control = $request->version_control;
            
            //Optional data
            if(isset($input['description']))
                $project->description = $input['description'];

            if(isset($input['end_date']))
                $project->end_date = $input['end_date'];

            if(isset($input['coordenator_id']))
                $project->coordenator_id = $input['coordenator_id'];

            if(isset($input['logo']))
                $project->logo = $input['logo'];

            
            $project->save();
            return new CustomJsonResponse(true, $project, 200);
        } else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function deleteProject(Request $request, $id){
        $project = $this->fetchProject($id);
        if($project == NULL) {
            return new CustomJsonResponse(false,"Project not found", 404);
        }
        $project->delete();
        return new CustomJsonResponse(true, "Project successfully deleted", 200);
    }

    private function getValidator($input, $id)
    {
        if($id == NULL) { //post (creation)
            $validationArray = [
                'name' => 'required|string',
                'description' => 'string',
                'start_date' => 'required|date',
                'end_date' => 'date',
                'coordenator_id' => 'numeric|exists:users,id',
                'logo' => 'url',
                'version_control' => 'required|url'
            ];
        } else { //put (update)
            $validationArray = [
                'name' => 'string', 
                'description' => 'string',
                'start_date' => 'date',
                'end_date' => 'date',
                'coordenator_id' => 'numeric|exists:users,id',
                'logo' => 'url',
                'version_control' => 'url'
            ];
        }

        $validator = \Validator::make($input, $validationArray);
        return $validator;
    }

}
