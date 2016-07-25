<?php namespace App\Http\Responses;


use Illuminate\Http\JsonResponse;

class CustomJsonResponse extends JsonResponse{

    public function __construct($success, $message = null, $status = 200){
        parent::__construct(array(
            'success' => $success,
            'data' => $message
        ), $status);
    }
}
