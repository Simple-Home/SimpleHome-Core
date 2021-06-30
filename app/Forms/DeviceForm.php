<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;

class DeviceForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('hostname', Field::TEXT, [
                'rules' => 'required|max:191',
                'label' => "Hostname"
            ])
            ->add('integration', Field::SELECT, [
                'choices' => array("MQTT", "Other"), //Change to Dynamically get installed integrations
                'rules' => 'required|max:35',
                'label' => "Integration"
            ])
            ->add('type', Field::SELECT, [
                'choices' => array("Light", "Toggle", "Speaker", "Sensor", "Other"),
                'rules' => 'required|max:191',
                'label' => "Type"
            ])
            ->add('sleep', Field::NUMBER, [
                'value' => '0',
                'rules' => 'required|max:1',
                'label' => "Sleep time (ms)"
            ])
            ->add('token', Field::TEXT, [
                'rules' => 'required|max:191',
                'label' => "Token"
            ])
            ->add('add', Field::BUTTON_SUBMIT, [
                'label' => "Save"
            ]);
    }
}
