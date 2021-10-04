<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;

class UserForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', Field::TEXT, [
                'rules' => 'required|max:255',
                'label' => "Username"
            ])
            ->add('email', Field::EMAIL, [
                'rules' => 'required|email|unique:users',
                'label' => "Email"
            ])
            ->add('password', Field::PASSWORD, [
                'rules' => 'required|confirmed',
                'label' =>  'Password'
            ])
            ->add('password_confirmation', Field::PASSWORD, [
                'rules' => 'required',
                'label' => 'Password confirm'
            ])
            ->add('add', Field::BUTTON_SUBMIT, [
                'label' => "Create"
            ]);
    }
}
