<?php

namespace App\Forms;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

class SettingEnvFieldsForm extends Form
{
    public function buildForm()
    {
        if (count($this->formOptions['variables']) > 0) {
            foreach ($this->formOptions['variables'] as $key => $value) {
                $args = [
                    'label' => $key,
                    'value' => $value,
                ];

                $this->add($key, Field::TEXT, $args);
            }

            $this->add('saveSetting', Field::BUTTON_SUBMIT, [
                'attr' => ["class" => "btn btn-primary  btn-block"],
                'label' => __('simplehome.save')
            ]);
        }
    }
}
