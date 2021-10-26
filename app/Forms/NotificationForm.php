<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;

class NotificationForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('mail', Field::CHECKBOX, [
                'label' => __('simplehome.notifyMail'),
                'attr' => ['value' => 'mail']
            ])
            ->add('database', Field::CHECKBOX, [
                'label' => __('simplehome.notifyDatabase'),
                'attr' => ['value' => 'database']
            ])
            ->add('firebase', Field::CHECKBOX, [
                'label' => __('simplehome.notifyFCM'),
                'attr' => ['value' => 'firebase']
            ])
            ->add('saveNotify', Field::BUTTON_SUBMIT, [
                'label' => __('simplehome.saveNotify'),
                'attr' => [
                    'class' => 'btn btn-primary  btn-block'
                    ],
                'wrapper' => ['class' => 'd-grid gap-2']
            ]);
    }
}
