<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Event;
use App\Http\Responses\CustomJsonResponse;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return Event::all();
    }

    private function fetchEvent($id){
        $event = Event::where('id', $id)->get()->first();
        if($event != NULL){
            return $event;
        }
        return NULL;
    }

    public function getEvent($id){
        $event = $this->fetchEvent($id);
        if($event == NULL){
            return new CustomJsonResponse(false,"Event not found", 404);
        }
        $event->load('organizations');
        return new CustomJsonResponse(true, $event, 200);
    }

    public function putEvent(Request $request, $id){
        $input = $request->except('_token');
        $validator = $this->getValidator($input, $id);
        if($validator->passes()) {
            $event = $this->fetchEvent($id);
            if($event == NULL) {
                return new CustomJsonResponse(false,"Event not found", 404);
            }

            if(isset($input['title']))
                $event->title = $input['title'];

            if(isset($input['description']))
                $event->description = $input['description'];

            if(isset($input['eventDate']))
                $event->eventDate = $input['eventDate'];

            if(isset($input['poster']))
                $event->poster = $input['poster'];

            if(isset($input['location']))
                $event->location = $input['location'];

            if(isset($input['external']))
                $event->external = $input['external'];

            $event->save();
            return new CustomJsonResponse(true, $event, 200);
        }  else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function postEvent(Request $request){

        $input = $request->except('_token');
        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $event = new Event;
            //Required data
            $event->title = $request->title;
            $event->description = $request->description;
            $event->eventDate = $request->eventDate;
            $event->external = $request->external;

            //Optional data
            if(isset($input['poster']))
                $event->poster = $input['poster'];

            if(isset($input['location']))
                $event->end_date = $input['location'];

            $event->save();
            return new CustomJsonResponse(true, $event, 200);
        } else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
        
    }

    public function deleteEvent(Request $request, $id){
        $event = $this->fetchEvent($id);
        if($event == NULL) {
            return new CustomJsonResponse(false,"Event not found", 404);
        }
        $event->delete();
        return new CustomJsonResponse(true, "Event successfully deleted", 200);
    }

    private function getValidator($input, $id)
    {
        if($id == NULL) { //post (creation)
            $validationArray = [
                'title' => 'required|string',
                'description' => 'required|string',
                'eventDate' => 'required|date',
                'external' => 'required|boolean',
                'poster' => 'url',
                'location' => 'string'
            ];
        } else { //put (update)
            $validationArray = [
                'title' => 'string',
                'description' => 'string',
                'eventDate' => 'date',
                'external' => 'boolean',
                'poster' => 'url',
                'location' => 'string'
            ];
        }

        $validator = \Validator::make($input, $validationArray);
        return $validator;
    }

    public function postOrganization(Request $request, $id, $organization_id) {
        $event = $this->fetchEvent($id);
        if($event == NULL) {
            return new CustomJsonResponse(false,"Event not found", 404);
        }

        if(\Validator::make(['organization_id' => $organization_id], ['organization_id' => 'exists:organizations,id'])->passes()) {
            if(!$event->organizations->contains($organization_id)) {
                $event->organizations()->attach($organization_id);
                $event->load('organizations'); //Refreshes the model
            }
            return new CustomJsonResponse(true, $event, 200);
        }
        return new CustomJsonResponse(false, "Organization does not exist", 404);
    }

    public function deleteOrganization(Request $request, $id, $organization_id) {
        $event = $this->fetchEvent($id);
        if($event == NULL) {
            return new CustomJsonResponse(false,"Event not found", 404);
        }

        foreach ($event->organizations as $organization) {
            if($organization->id == $organization_id) {
                $event->organizations()->detach($organization_id);
                $event->load('organizations'); //Refreshes the model
                return new CustomJsonResponse(true, $event, 200);
            }
        }
        return new CustomJsonResponse(false, "Event isn't associated to this organization", 404);
    }
}
