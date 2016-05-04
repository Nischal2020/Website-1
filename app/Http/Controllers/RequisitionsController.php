<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Requisitions;

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

    public function getRequisition($id){
    	$requisition = Requisition::where('id', $id)->get()->first();
    	if($requisition != NULL){
    		return $requisition;
    	}
        \App::abort(404);
        return NULL;
    }

    public function putRequisition(Request $request, $id){
    	$input = $request->except('_token');
    	$requisition = $this->getrequisition($id);
    	if($requisition == NULL) {
            \App::abort(404);
            return NULL;
        }

        $requisition->update($input);
    }

    public function postRequisition(Request $request){
        
        $requisition = new Requisition;
        $requisition->designation = $request->designation;
        $requisition->save();        
        
    }

    public function deleteRequisition(Request $request, $id){
        $requisition = $this->getrequisition($id);
        if($requisition == NULL) {
            \App::abort(404);
            return NULL;
        }
        $requisition->delete();
    }

}
