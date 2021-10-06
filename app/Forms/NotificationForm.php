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
                'label' => __('simplehome.notifyMail'),
                'attr' => ['value' => 'database']
            ])
            ->add('fcm', Field::CHECKBOX, [
                'label' => __('simplehome.notifyMail'),
                'attr' => ['value' => 'fcm']
            ])
            ->add('saveNotify', Field::BUTTON_SUBMIT, [
                'label' => __('simplehome.saveNotify')
            ]);
    }
}
