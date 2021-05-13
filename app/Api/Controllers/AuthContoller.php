<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use Validator;

class AuthController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Client Login
     */
    public function postLogin(Request $request)
    {
        // Validations
        $rules = [
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        } else {
            // Fetch User
            $user = User::where('email', $request->email)->first();
            if ($user) {
                // Verify the password
                if (password_verify($request->password, $user->password)) {
                    // Update Token
                    $postArray = ['api_token' => $this->apiToken];
                    $login = User::where('email', $request->email)->update($postArray);

                    if ($login) {
                        return response()->json([
                            'name'         => $user->name,
                            'email'        => $user->email,
                            'access_token' => $this->apiToken,
                        ]);
                    }
                } else {
                    return response()->json([
                        'message' => 'Invalid Password',
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'User not found',
                ]);
            }
        }
    }
}
