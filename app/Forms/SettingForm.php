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
        $user = Auth::user();
        $this
            ->add('language', Field::SELECT, [
                'rules' => 'required',
                'label' => __('user.language'),
                'choices' => [1 => 'English', 2 => 'Čeština'],
                'selected' => (!empty ($user->language) ? $user->language : 1)
            ])
            ->add('saveSetting', Field::BUTTON_SUBMIT, [
                'label' => __('web.save')
            ]);
    }
}
