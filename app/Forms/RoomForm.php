<?php

namespace App\Forms;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;

use Kris\LaravelFormBuilder\Form;

class RoomForm extends Form
{
    public function buildForm()
    {
        if (empty ($this->getData('edit'))) {
            $this
                ->add('name', Field::TEXT, [
                    'rules' => 'required|max:255',
                    'label' => 'Room name'
                ])
                ->add('add', Field::BUTTON_SUBMIT, [
                    'label' => "Save"
                ]);
        } else {
            $this
                ->add('name', Field::TEXT, [
                    'rules' => 'required|max:255',
                    'label_show' => false,
                    'attr' => ['onchange' => 'this.form.submit()']
                ]);
        }
    }
}
