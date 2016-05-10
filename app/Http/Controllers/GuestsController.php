<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Guest;

class GuestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return Guest::all();
    }

    public function getGuest($id){
        $guest = Guest::where('id', $id)->get()->first();
        if($guest != NULL){
            return $guest;
        }
        \App::abort(404);
        return NULL;
    }

    public function putGuest(Request $request, $id){
        $input = $request->except('_token');
        $guest = $this->getGuest($id);
        if($guest == NULL) {
            \App::abort(404);
            return NULL;
        }

        $guest->update($input);
    }

    public function postGuest(Request $request){
        
        $guest = new Guest;
        $guest->designation = $request->designation;
        $guest->save();        
        
    }

    public function deleteGuest(Request $request, $id){
        $guest = $this->getGuest($id);
        if($guest == NULL) {
            \App::abort(404);
            return NULL;
        }
        $guest->delete();
    }

}
