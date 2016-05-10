<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Event;

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

    public function getEvent($id){
        $event = Event::where('id', $id)->get()->first();
        if($event != NULL){
            return $event;
        }
        \App::abort(404);
        return NULL;
    }

    public function putEvent(Request $request, $id){
        $input = $request->except('_token');
        $event = $this->getEvent($id);
        if($event == NULL) {
            \App::abort(404);
            return NULL;
        }

        $event->update($input);
    }

    public function postEvent(Request $request){
        
        $event = new Event;
        $event->designation = $request->designation;
        $event->save();        
        
    }

    public function deleteEvent(Request $request, $id){
        $event = $this->getEvent($id);
        if($event == NULL) {
            \App::abort(404);
            return NULL;
        }
        $event->delete();
    }

}
