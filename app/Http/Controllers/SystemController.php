<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Helpers\SettingManager;
use Nwidart\Modules\Module;
use App\Models\Devices;


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
            $providetDevices = count(Devices::where('integration', $integration->getLowerName())->get());
            $integrations[] = [
                "name" => $integration->getName(),
                "slug" => $integration->getLowerName(),
                "providetDevices" => $providetDevices,
            ];
        }

        return view('system.integrations.list', compact('integrations'));
    }

    public function detail($integrationSlug, FormBuilder $formBuilder)
    {
        $settings = SettingManager::getGroup($integrationSlug);
        $systemSettingsForm  = $formBuilder->create(\App\Forms\SettingDatabaseFieldsForm::class, [
            'method' => 'POST',
            'url' => route('system.settings.update'),
            'variables' => $settings
        ]);

        return view('system.integrations.detail', compact('settings', 'systemSettingsForm'));
    }
}
