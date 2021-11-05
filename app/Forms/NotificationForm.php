<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class NotificationForm extends Form
{
    public function buildForm()
    {
        $user = $this->getData('user');
        $userNotificationPreferencies = ($user->notification_preferences != null ? $user->notification_preferences : []);
        
        foreach (["mail","database","firebase"] as $key => $value) {
            $this->add($value, Field::CHECKBOX, [
                'label' => __('simplehome.notify.'.$value),
                'attr' => [
                    'value' => $value,
                    'class'=>'form-check-input bg-light',
                    'checked' => in_array($value,$userNotificationPreferencies)
                ],
            ]);
            }
            $this ->add('saveNotify', Field::BUTTON_SUBMIT, [
                'label' => __('simplehome.saveNotify'),
                'attr' => [
                    'class' => 'btn btn-primary  btn-block mt-3'
                ],
                'wrapper' => [
                    'class' => 'd-grid gap-2'
                ],
            ]);
        }
    }
    