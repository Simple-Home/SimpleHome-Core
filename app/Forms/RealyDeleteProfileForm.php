<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class RealyDeleteProfileForm extends Form
{
    public function buildForm()
    {
        $this
            ->add("text", Field::STATIC, [
                'tag' => 'label',
                'attr' => ['class' => 'form-control-static'],
                'value' => "Realy want delete your account?",
                'label_show' => FALSE
            ])
            ->add('deleteProfile', Field::BUTTON_SUBMIT, [
                'label' => "Realy delete account"
            ]);
    }
}
