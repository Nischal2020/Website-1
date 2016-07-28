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
        $project->load('organizations');
        $project->load('programmingLanguages');
        return new CustomJsonResponse(true, $project, 200);
    }

    public function putProject(Request $request, $id){
        $input = $request->all();
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
        $input = $request->all();
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

    public function postOrganization(Request $request, $id, $organization_id) {
        $project = $this->fetchProject($id);
        if($project == NULL){
            return new CustomJsonResponse(false,"Project not found", 404);
        }

        if(\Validator::make(['organization_id' => $organization_id], ['organization_id' => 'exists:organizations,id'])->passes()) {
            if(!$project->organizations->contains($organization_id)) {
                $project->organizations()->attach($organization_id);
                $project->load('organizations'); //Refreshes the model
            }
            return new CustomJsonResponse(true, $project, 200);
        }
        return new CustomJsonResponse(false, "Organization does not exist", 404);
    }

    public function deleteOrganization(Request $request, $id, $organization_id) {
        $project = $this->fetchProject($id);
        if($project == NULL){
            return new CustomJsonResponse(false,"Project not found", 404);
        }

        foreach ($project->organizations as $organization) {
            if($organization->id == $organization_id) {
                $project->organizations()->detach($organization_id);
                $project->load('organizations'); //Refreshes the model
                return new CustomJsonResponse(true, $project, 200);
            }
        }
        return new CustomJsonResponse(false, "Project isn't with this organization", 404);
    }

    public function postProgrammingLanguage(Request $request, $id, $programming_language_id) {
        $project = $this->fetchProject($id);
        if($project == NULL){
            return new CustomJsonResponse(false,"Project not found", 404);
        }

        if(\Validator::make(['programming_language_id' => $programming_language_id], ['programming_language_id' => 'exists:programming_languages,id'])->passes()) {
            if(!$project->programmingLanguages->contains($programming_language_id)) {
                $project->programmingLanguages()->attach($programming_language_id);
                $project->load('programmingLanguages'); //Refreshes the model
            }
            return new CustomJsonResponse(true, $project, 200);
        }
        return new CustomJsonResponse(false, "Programming Language does not exist", 404);
    }

    public function deleteProgrammingLanguage(Request $request, $id, $programming_language_id) {
        $project = $this->fetchProject($id);
        if($project == NULL){
            return new CustomJsonResponse(false,"Project not found", 404);
        }

        foreach ($project->programmingLanguages as $programmingLanguage) {
            if($programmingLanguage->id == $programming_language_id) {
                $project->programmingLanguages()->detach($programming_language_id);
                $project->load('programmingLanguages'); //Refreshes the model
                return new CustomJsonResponse(true, $project, 200);
            }
        }
        return new CustomJsonResponse(false, "Project doesn't use this programming language", 404);
    }

}
