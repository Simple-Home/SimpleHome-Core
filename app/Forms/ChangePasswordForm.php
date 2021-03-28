<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;

class ChangePasswordForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('oldPassword', Field::PASSWORD, [
                'rules' => 'required|max:255',
                'label' => "Old password"
            ])
            ->add('newPassword', Field::PASSWORD, [
                'rules' => 'required|max:255',
                'label' => "New password"
            ])
            ->add('confirmPassword', Field::PASSWORD, [
                'rules' => 'required|max:255',
                'label' => "Confirm password"
            ])
            ->add('changePassword', Field::BUTTON_SUBMIT, [
                'label' => "Change"
            ]);
    }
}
