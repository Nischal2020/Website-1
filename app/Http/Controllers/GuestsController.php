<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Guest;
use App\Http\Responses\CustomJsonResponse;

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

    private function fetchGuest($identification){

        $idPossibilities = array("id", "name", "email");
        foreach($idPossibilities as $id){
            $guest = Guest::where($id, $identification)->get()->first();
            if($guest != NULL){
                return $guest;
            }
        }
        return NULL;
    }

    public function getGuest($id){
        $guest = $this->fetchGuest($id);
        if($guest == NULL){
            return new CustomJsonResponse(false,"Guest not found", 404);
        }
        return new CustomJsonResponse(true, $guest, 200);
    }

    public function putGuest(Request $request, $id){
        $input = $request->except('_token');
        $validator = $this->getValidator($input, $id);
        if($validator->passes()) {
            $guest = $this->fetchGuest($id);
            if($guest == NULL) {
                return new CustomJsonResponse(false,"Guest not found", 404);
            }

            if(isset($input['name']))
                $guest->name = $input['name'];

            if(isset($input['email']))
                $guest->email = $input['email'];

            $guest->save();
            return new CustomJsonResponse(true, $guest, 200);
        }  else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function postGuest(Request $request){

        $input = $request->except('_token');
        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $guest = new Guest;
            $guest->name = $request->name;
            $guest->email = $request->email;
            $guest->save();
            return new CustomJsonResponse(true, $guest, 200);
        } else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
        
    }

    public function deleteGuest(Request $request, $id){
        $guest = $this->fetchGuest($id);
        if($guest == NULL) {
            return new CustomJsonResponse(false,"Guest not found", 404);
        }
        $guest->delete();
        return new CustomJsonResponse(true, "Guest successfully deleted", 200);
    }

    private function getValidator($input, $id)
    {
        if($id == NULL) { //post (creation)
            $validationArray = [
                'name' => 'required|string',
                'email' => 'required|email|unique:guests'
            ];
        } else { //put (update)
            $validationArray = [
                'name' => 'string',
                'email' => 'email|unique:guests'
            ];
        }

        $validator = \Validator::make($input, $validationArray);
        return $validator;
    }

}
