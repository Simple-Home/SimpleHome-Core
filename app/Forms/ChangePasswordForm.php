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
                'label' => __('simplehome.oldPassword')
            ])
            ->add('newPassword', Field::PASSWORD, [
                'rules' => 'required|max:255',
                'label' =>  __('simplehome.newPassword')
            ])
            ->add('confirmPassword', Field::PASSWORD, [
                'rules' => 'required|max:255',
                'label' => __('simplehome.passwordConfirm')
            ])
            ->add('changePassword', Field::BUTTON_SUBMIT, [
                'label' =>  __('simplehome.changePassword'),
                'attr' => [
                    'class' => 'btn btn-primary btn-block'
                ],
                'wrapper' => ['class' => 'd-grid gap-2']
            ]);
    }
}
