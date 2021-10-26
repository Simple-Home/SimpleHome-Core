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
                'label' => "Logs list",
                'attr' => (empty($this->getData('logFiles')) ? ['disabled' => 'disabled'] : [])
            ])
            ->add('delete', Field::BUTTON_SUBMIT, [
                'attr' => [
                    'name' => 'delete',
                    'value' => 1,
                    'class' => 'btn btn-danger btn-block'
                ],
                'label' => "Delete",
                'wrapper' => ['class' => 'd-grid gap-2']
            ])
            ->add('select', Field::BUTTON_SUBMIT, [
                'label' => "Select",
                'attr' => [
                    'class' => 'btn btn-primary btn-block  mt-3'
                    ],
                'wrapper' => ['class' => 'd-grid gap-2']
            ]);
    }
}


