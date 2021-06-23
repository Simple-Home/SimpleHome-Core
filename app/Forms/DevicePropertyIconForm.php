<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;

class DevicePropertyIconForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('icon', Field::BUTTON_BUTTON, [
                'attr' => ['class' => 'btn btn-secondary iconButton', 'id' => 'icon', 'role' => 'iconpicker', 'data-icon' => (!empty($this->getData('icon')) ? $this->getData('icon') : "")],
            ])
            ->add('id', Field::HIDDEN, [
                'rules' => 'required'
            ]);
    }
}
