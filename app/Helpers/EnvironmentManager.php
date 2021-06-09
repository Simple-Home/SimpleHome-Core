<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EnvironmentManager extends \RachidLaasri\LaravelInstaller\Helpers\EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent()
    {
        if (! file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }
        return file_get_contents($this->envPath);
    }
   
    /**
     * Get the the .env file path.
     *
     * @return string
     */
    public function getEnvPath()
    {
        return $this->envPath;
    }

    /**
     * Get the the .env.example file path.
     *
     * @return string
     */
    public function getEnvExamplePath()
    {
        return $this->envExamplePath;
    }

    /**
     * Save the edited content to the .env file.
     *
     * @param Request $input
     * @return string
     */
    public function saveFileClassic(Request $input)
    {
        $message = trans('installer_messages.environment.success');

        try {
           // file_put_contents($this->envPath, $input->get('envConfig'));
        } catch (Exception $e) {
            $message = trans('installer_messages.environment.errors');
        }

        return $message;
    }

    /**
     * Save the form content to the .env file.
     *
     * @param Request $request
     * @return string
     */
    public function saveFileWizard(Request $request)
    {
        $results = trans('installer_messages.environment.success');

        $envFileData =
        'APP_NAME=\''.$request->app_name."'\n".
        'APP_ENV='.$request->environment."\n".
        'APP_KEY='.'base64:'.base64_encode(Str::random(32))."\n".
        'APP_DEBUG='.$request->app_debug."\n".
        "APP_TIMEZONE='UTC'"."\n".
        'APP_LOG_LEVEL='.$request->app_log_level."\n".
        'APP_URL='.$request->app_url."\n\n".
        'DB_CONNECTION='.$request->database_connection."\n".
        'DB_HOST='.$request->database_hostname."\n".
        'DB_PORT='.$request->database_port."\n".
        'DB_DATABASE='.$request->database_name."\n".
        'DB_USERNAME='.$request->database_username."\n".
        'DB_PASSWORD='.$request->database_password."\n\n".
        'BROADCAST_DRIVER='.$request->broadcast_driver."\n".
        'CACHE_DRIVER='.$request->cache_driver."\n".
        'SESSION_DRIVER='.$request->session_driver."\n".
        'SESSION_LIFETIME=120'."\n".
        'MEMCACHED_HOST=127.0.0.1'."\n".
        'QUEUE_DRIVER='.$request->queue_driver."\n\n".
        'REDIS_HOST='.$request->redis_hostname."\n".
        'REDIS_PASSWORD='.$request->redis_password."\n".
        'REDIS_PORT='.$request->redis_port."\n\n".
        'MAIL_MAILER=sendmail'."\n".
        'MAIL_HOST=localhost'."\n".
        'MAIL_PORT=2525'."\n".
        'MAIL_FROM_ADDRESS=info@yoursDomain.cz'."\n".
        'MAIL_FROM_NAME="${APP_NAME}"'."\n\n".
        'AWS_ACCESS_KEY_ID='."\n".
        'AWS_SECRET_ACCESS_KEY='."\n".
        'AWS_DEFAULT_REGION=us-east-1'."\n".
        'AWS_BUCKET='."\n\n".
        'PUSHER_APP_ID='.$request->pusher_app_id."\n".
        'PUSHER_APP_KEY='.$request->pusher_app_key."\n".
        'PUSHER_APP_SECRET='.$request->pusher_app_secret."\n".
        'PUSHER_APP_CLUSTER=mt1'."\n\n".
        'MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"'."\n".
        'MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"'."\n";
        
        /*Create User*/
        if($request->create_account_password == $request->create_account_password_confirmation) {
            $newAccount = ['name'=>$request->create_account_name, 'email'=>$request->create_account_email, 'password'=>bcrypt($request->create_account_password)];
            app('App\Models\User')->create($newAccount);
        }
        try {
            file_put_contents($this->envPath, $envFileData);
        } catch (Exception $e) {
            $results = trans('installer_messages.environment.errors');
        }

        return $results;
    }
}
