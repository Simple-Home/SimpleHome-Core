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
                'label' => "Delete"
            ])
            ->add('select', Field::BUTTON_SUBMIT, [
                'label' => "Select"
            ]);
    }
}
