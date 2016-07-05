<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Responses\CustomJsonResponse;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiAuthenticateController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return new CustomJsonResponse(false,"Invalid credentials", 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return new CustomJsonResponse(false,"Could not create token", 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }
}