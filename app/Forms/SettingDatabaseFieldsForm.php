<?php

namespace App\Forms;

use App\Models\User;
use App\Models\Currency;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SettingDatabaseFieldsForm extends Form
{
    private $types = [
        'string' => Field::TEXT,
        'int' => Field::NUMBER,
    ];

    public function buildForm()
    {
        foreach ($this->formOptions['variables'] as $key => $value) {
            if (isset($this->types[$value->type])) {
                $this->add($value->name, $this->types[$value->type], [
                    'rules' => 'required',
                    'label' => __($value->name),
                    'value' => $value->value,
                ]);
            } else {
                $this->add($value->name, Field::STATIC, [
                    'value' => 'Type ' . $value->type . ' is not supported',
                ]);
            }
        }

        $this->add('saveSetting', Field::BUTTON_SUBMIT, [
            'attr' => ["class" => "btn btn-primary  btn-block"],
            'label' => __('simplehome.save')
        ]);
    }
}
