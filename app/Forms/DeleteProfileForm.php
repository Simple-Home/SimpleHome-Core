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
                'label' => __('simplehome.users.delete'),
                'attr' => ['class' => 'btn btn-danger btn-block'],
                'wrapper' => ['class' => 'd-grid gap-2']
            ]);
    }
}
