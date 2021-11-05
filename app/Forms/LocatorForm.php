<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;

class LocatorForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('locator_id', Field::SELECT, [
                'choices' => (!empty($this->getData('properties')) ? $this->getData('properties') : array(null => "Nothing")),
                'label' => "Properties"
            ])
            ->add('saveLocator', Field::BUTTON_SUBMIT, [
                'label' => __('simplehome.save'),
                'attr' => [
                    'class' => 'btn btn-primary'
                    ],
                'wrapper' => ['class' => 'd-grid gap-2']
            ]);
    }
}
