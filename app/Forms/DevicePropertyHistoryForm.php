<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;

class DevicePropertyHistoryForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('history', Field::NUMBER, [
                'rules' => 'required',
                'attr' => ['onchange' => "this->form->submit();"],
                'label_show' => false
            ])
            ->add('id', Field::HIDDEN, [
                'rules' => 'required'
            ]);
    }
}
