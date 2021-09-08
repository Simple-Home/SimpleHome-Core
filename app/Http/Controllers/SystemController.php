<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Helpers\SettingManager;
use Nwidart\Modules\Module;


class SystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function integrationsList()
    {
        $integrationsRaw = \Module::all();
        $integrations = [];

        foreach ($integrationsRaw as $key => $integration) {
            $integrations[] = [
                "name" => $integration->getName(),
                "slug" => $integration->getLowerName(),
            ];
        }

        return view('system.integrations.list', compact('integrations'));
    }
}
