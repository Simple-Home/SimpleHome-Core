<?php

namespace App\Forms;

use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

class DeviceForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('hostname', Field::TEXT, [
                'rules' => 'required|max:191',
                'label' => "Hostname"
            ])
            ->add('integration', Field::TEXT, [
                'rules' => 'required|max:255',
                'label' => "Integration",
                'attr' => ['list' => 'integrations']
            ])
            ->add('type', Field::SELECT, [
                'choices' => array("light" => "Light", "toggle" => "Toggle", "speaker" => "Speaker", "sensor" => "Sensor", "other" => "Other"),
                'rules' => 'required|max:191',
                'label' => "Type"
            ])
            ->add('sleep', Field::NUMBER, [
                'value' => '0',
                'rules' => 'required|max:1',
                'label' => "Sleep time (ms)"
            ])
            ->add('room_id', Field::SELECT, [
                'choices' => (!empty($this->getData('rooms')) ? $this->getData('rooms') : array(0 => "Nothing")),
                'rules' => 'required',
                'label' => "Room"
            ])
            ->add('token', Field::TEXT, [
                'rules' => 'max:191',
                'label' => "Token"
            ])
            ->add('add', Field::BUTTON_SUBMIT, [
                'label' => "Save",
                'attr' => [
                    'class' => 'btn btn-primary btn-block'
                    ],
                'wrapper' => ['class' => 'd-grid gap-2']
            ]);
    }
}
