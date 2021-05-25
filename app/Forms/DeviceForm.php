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
                'rules' => 'required|max:255',
                'label' => "Hostname"
            ])
            ->add('type', Field::TEXT, [
                'rules' => 'required|max:255',
                'label' => "Type"
            ])
            ->add('sleep', Field::NUMBER, [
                'rules' => 'required|max:255',
                'label' => "Sleep time (min)"
            ])
            ->add('token', Field::TEXT, [
                'rules' => 'required|max:255',
                'label' => "Token"
            ])
            ->add('add', Field::BUTTON_SUBMIT, [
                'label' => "Save"
            ]);
    }
}
