<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Storage;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list(Request $request, FormBuilder $formBuilder)
    {
        $logsAll = $this->logFile();
        $logs = $logsAll[0];
        asort($logs);

        $logForm = $formBuilder->create(\App\Forms\LogForm::class, [
            'model' => (!empty ($request->input ('logFile')) ? $request->input ('logFile') : ""),
            'method' => 'POST',
            'url' => route('system.logs'),
        ], ['logFiles' => $logsAll[1]]);
        
        if ($request->input ('logFile') != null) {
            $content = file_get_contents(storage_path ('logs/' . $logs[$request->input ('logFile')]));
        } else {
            $content = "";
        }

        return view('system.logs.list', compact('logs', 'logForm', 'content'));
    }

    private function logFile () {
        $result = array();
        $dir = storage_path('logs/');
		$logFiles = scandir ($dir);
		foreach ($logFiles as $key => $file) {
			if (in_array ($file,array (".", "..", ".gitkeep", ".gitignore")))
			{
				continue;
			}
			$result[0][] = $file;
            $result[1][] = $file . " - " . $this->bytesToHuman(filesize($dir . $file));
		}
		return $result;
	}

    public static function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
