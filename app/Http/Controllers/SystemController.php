<?php

namespace App\Http\Controllers;

use App\Helpers\SettingManager;
use App\Models\Devices;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Kris\LaravelFormBuilder\FormBuilder;
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

        $module = \Module::find($integrationSlug);
        $providetDevices = Devices::where('integration', $module->getLowerName())->get();
        
        $integration = [
            "name" => $module->getName(),
            "slug" => $module->getLowerName(),
            "providetDevices" => $providetDevices
        ];
        return view('system.integrations.detail', compact('settings', 'systemSettingsForm', 'integration'));
    }
}
