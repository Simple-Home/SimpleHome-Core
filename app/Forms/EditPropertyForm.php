<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;

class EditPropertyForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('room', Field::TEXT, [
                'rules' => 'required|max:255',
                'label' => "Old password"
            ])
            ->add('changePassword', Field::BUTTON_SUBMIT, [
                'label' => "Change",
                'attr' => [
                    'class' => 'btn btn-primary  btn-block'
                    ],
                'wrapper' => ['class' => 'd-grid gap-2']
            ]);
    }
}
