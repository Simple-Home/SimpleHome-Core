<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Storage;
use App\Models\Locations;
use Illuminate\Support\Facades\View;
use Laravel\Passport\Client;
use Laravel\Passport\Token;


class DevelopmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('system.developments.index');
    }
     
    public function listAjax(Request $request)
    {
        //https: //developers.google.com/oauthplayground/#step1&scopes=*&url=https%3A%2F%2F&content_type=application%2Fjson&http_method=GET&useDefaultOauthCred=unchecked&oauthEndpointSelect=Custom&oauthAuthEndpointValue=http%3A%2F%2Fdev.steelants.cz%2Fvasek%2Fsimple-home-v4%2Fpublic%2Foauth%2Fauthorize&oauthTokenEndpointValue=http%3A%2F%2Fdev.steelants.cz%2Fvasek%2Fsimple-home-v4%2Fpublic%2Foauth%2Ftoken&oauthClientId=6&oauthClientSecret=m7JVBeurxudwZR3ManIPd4Eb9FS3Oj2EZ8nXeYHp&includeCredentials=checked&accessTokenType=bearer&autoRefreshToken=unchecked&accessType=offline&prompt=consent&response_type=code&wrapLines=on
        
        if ($request->ajax()) {
            $user = auth()->user();
            $tokens = Token::with('client')->get();
            $personalAccessTokens = $tokens->load('client')->filter(function ($token) {
                return $token->client->personal_access_client;
            })->all();

            //oAuth
            $authorizedClients = Client::all();
            $authenticatedApps = Token::all();
            $personalTokens  =  $personalAccessTokens;
            return View::make("system.developments.ajax.list")
                ->with("authorizedClients", $authorizedClients)
                ->with("authenticatedApps", $authenticatedApps)
                ->with("personalTokens", $personalTokens)
                ->render();
        }

        return redirect()->back();
    }

    public function newPersonalAjax(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            $values = $request->all();
            $token = $user->createToken($values['tokenName'])->accessToken;
            return $token;
        }
        return redirect()->back();
    }

    public function newAjax(Request $request)
    {
        if ($request->ajax()) {
            return View::make("system.developments.form.edit")->render();
        }
        return redirect()->back();
    }

    public function removeToken(string $token_id)
    {
        $location = Token::find($token_id);
        $location->delete();
        return redirect()->back()->with('error', 'Token removed.');;
    }

    public function removeClient(int $client_id)
    {
        $location = Client::find($client_id);
        $location->delete();
        return redirect()->back()->with('error', 'Client removed.');;
    }

    public function revokeToken(string $token_id)
    {
        $location = Token::find($token_id);
        $location->revoke();
        return redirect()->back()->with('error', 'Token revoked.');;
    }
}


