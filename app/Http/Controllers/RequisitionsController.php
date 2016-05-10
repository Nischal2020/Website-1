<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Requisition;
use App\Http\Responses\CustomJsonResponse;

class RequisitionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return Requisition::all();
    }

    private function fetchRequisition($id){
        $requisition = Requisition::where('id', $id)->get()->first();
        if($requisition != NULL) {
            return $requisition;
        }
        return NULL;
    }

    public function getRequisition($id){
        $requisition = $this->fetchRequisition($id);
        if($requisition == NULL)
            return new CustomJsonResponse(false,"Requisition not found", 404);

        return new CustomJsonResponse(true, $requisition, 200);
    }

    public function putRequisition(Request $request, $id){
        $input = $request->except('_token');
        $validator = $this->getValidator($input, $id);
        if($validator->passes()) {
            $requisition = $this->fetchRequisition($id);
            if($requisition == NULL) {
                return new CustomJsonResponse(false,"Requisition not found", 404);
            }

            if(isset($input['requisition_date']))
                $requisition->requisition_date = $input['requisition_date'];
            
            if(isset($input['return_date']))
                $requisition->return_date = $input['return_date'];

            $requisition->save();
            return new CustomJsonResponse(true, $requisition, 200);
        }  else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function postRequisition(Request $request){
        $input = $request->except('_token');
        $validator = $this->getValidator($input, NULL);
        if($validator->passes()) {
            $requisition = new Requisition;
            $requisition->requisition_date = $request->requisition_date;
            $requisition->save();
            return new CustomJsonResponse(true, $requisition, 200);
        } else {
            return new CustomJsonResponse(false, $validator->errors()->all(), 400); //400 is Bad Request
        }

        //It shouldn't reach this point.
        return new CustomJsonResponse(false,"Internal Server Error", 500); //500 is Internal Server Error.
    }

    public function deleteRequisition(Request $request, $id){
        $requisition = $this->fetchRequisition($id);
        if($requisition == NULL) {
            return new CustomJsonResponse(false,"Requisition not found", 404);
        }
        $requisition->delete();
        return new CustomJsonResponse(true, "Requisition successfully deleted", 200);
    }

    private function getValidator($input, $id)
    {
        if($id == NULL) { //post (creation)
            $validationArray = [
                'requisition_date' => 'required|date', //we may change date to whatever format we want. See date_format:format
            ];
        } else { //put (update)
            $validationArray = [
                'requisition_date' => 'date',
                'return_date' => 'required|date', //If more columns are added to requisitions (thus to this validation) remove required here
            ];
        }

        $validator = \Validator::make($input, $validationArray);
        return $validator;
    }

}
