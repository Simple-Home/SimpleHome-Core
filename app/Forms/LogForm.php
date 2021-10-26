<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;

class LogForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('logFile', Field::SELECT, [
                'choices' => $this->getData('logFiles'),
                'label' => "Logs list"
            ])
            ->add('delete', Field::BUTTON_SUBMIT, [
                'attr' => ['name' => 'delete', 'value' => 1],
                'label' => "Delete",
                'attr' => [
                    'class' => 'btn btn-danger  btn-block'
                    ]
            ])
            ->add('select', Field::BUTTON_SUBMIT, [
                'label' => "Select",
                'attr' => [
                    'class' => 'btn btn-primary btn-block'
                    ],
                'wrapper' => ['class' => 'd-grid gap-2']
            ]);
    }
}
