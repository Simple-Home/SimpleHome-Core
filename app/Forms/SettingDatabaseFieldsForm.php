<?php

namespace App\Forms;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

class SettingDatabaseFieldsForm extends Form
{
    private $types = [
        'string' => Field::TEXT,
        'int' => Field::NUMBER,
        'color' => Field::COLOR,
        'bool' => Field::CHECKBOX,
    ];

    public function buildForm()
    {
        if (count($this->formOptions['variables']) > 0) {
            foreach ($this->formOptions['variables'] as $key => $value) {
                if (isset($this->types[$value->type])) {
                    $args = [
                        'rules' => 'required',
                        'label' => __($value->name),
                        'value' => $value->value,
                    ];

                    if ($value->type == "bool" && $value->value) {
                        $args["checked"] = $value->value;
                        $args['rules'] = "";
                    }

                    $this->add($value->name . "#" . $value->group, $this->types[$value->type], $args);
                } else {
                    $this->add($value->name . "#" . $value->group, Field::STATIC, [
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
}
