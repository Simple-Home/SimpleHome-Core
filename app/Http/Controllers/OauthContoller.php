<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OauthContoller extends Controller
{
    public function login()
    {
        return view('oauth.login');
    }
}
