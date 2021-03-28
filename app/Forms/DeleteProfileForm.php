<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class DeleteProfileForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('deleteProfile', Field::BUTTON_SUBMIT, [
                'label' => "Delete account",
                'attr' => ['class' => 'btn btn-danger']
            ]);
    }
}
