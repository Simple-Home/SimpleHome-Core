<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;

use Kris\LaravelFormBuilder\FormBuilder;

class EnvController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(FormBuilder $formBuilder)
    {
        $environmentVariables = $_ENV;

        foreach ($environmentVariables as $environmentVariableKey => $environmentVariable) {
            if (str_starts_with($environmentVariableKey, "MIX_")) {
                unset($environmentVariables[$environmentVariableKey]);
            }
            if ($environmentVariableKey == "APP_KEY") {
                unset($environmentVariables[$environmentVariableKey]);
            }
        }

        $systemEnvSettingsForm  = $formBuilder->create(\App\Forms\SettingEnvFieldsForm::class, [
            'method' => 'POST',
            'url' => route('system.env.store'),
            'variables' => $environmentVariables,
        ]);

        return view('system.env.index', compact('systemEnvSettingsForm'));
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        unset($inputs['_token']);

        foreach ($inputs as $key => $value) {
            if (env($key) == $value)
                continue;

            dump($key);
            dump($value);
            $this->setEnv($key, $value);
        }

        // //Artisan::call('cache:clear');
        // Artisan::call('config:cache');

        //die();

        return redirect()->route('system.env')->with('success', 'Environment Variables were changed.');
    }

    private function setEnv($key, $value)
    {
        $fileContent = file_get_contents(app()->environmentFilePath());

        $fileContent =  str_replace(
            $key . '=' . (boolval(env($key)) ? (env($key) ? 'true' : 'false') : env($key)),
            $key . '=' . "$value",
            $fileContent,
        );

        //dump($key . '=' . (boolval(env($key)) ? (env($key) ? 'true' : 'false') : env($key)));
        //dump($key . '=' . "$value");

        file_put_contents(app()->environmentFilePath(), $fileContent);
        /*file_put_contents(app()->environmentFilePath(), str_replace(
            $key . '=' . env($key),
            $key . '=' . "$value",
            file_get_contents(app()->environmentFilePath())
        ));*/
    }
}
