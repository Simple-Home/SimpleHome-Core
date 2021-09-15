<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OauthContoller extends Controller
{
    public function login()
    {
        return view('oauth.login');
    }

    public function callback(Request $request)
    {
    }

    public function redirect()
    {
        $queries = http_build_query([
            'client_id' => '3',
            'redirect_uri' => 'https://dev.steelants.cz/vasek/simple-home-v4/public/oauth/callback',
            'response_type' => 'code',
        ]);
        return redirect("https://dev.steelants.cz/vasek/simple-home-v4/public/oauth/authorize?" . $queries);
    }
}
