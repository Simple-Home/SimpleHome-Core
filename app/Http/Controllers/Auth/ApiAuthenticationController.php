<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Str;

class ApiAuthenticationController extends Controller {
    public function __construct(){

    }

    /**
     * Client Register
     */
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('v2 API Authentication Token')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }


    /**
     * Client Login
     */
    public function login (Request $request) { 
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('v2 API Authentication Token')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                //invalid password
                $response = ["message" => "Invalid username/password"];
                return response($response, 422);
            }
        } else {
            //User does not exist
            $response = ["message" =>'Invalid username/password'];
            return response($response, 422);
        }
    }

    /**
     * Client Logout
     */
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'log out successfull'];
        return response($response, 200);
    }
}
