<?php

namespace App\Forms;

use App\Models\User;
use App\Models\Currency;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SettingForm extends Form
{
    public function buildForm()
    {
        $user = auth()->user();
        $this
            ->add('language', Field::SELECT, [
                'rules' => 'required',
                'label' => __('user.language'),
                'choices' => [
                    'en' => 'English',
                    'cs' => 'Čeština',
                    'de' => 'German',
                ],
                'selected' => (!empty ($user->language) ? $user->language : 'en')
            ])
            ->add('saveSetting', Field::BUTTON_SUBMIT, [
                'label' => __('simplehome.save'),
                'attr' => [
                    'class' => 'btn btn-primary'
                    ],
                'wrapper' => ['class' => 'd-grid gap-2']
            ]);
    }
}
