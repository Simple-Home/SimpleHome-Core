<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;

class PropertyForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('nick_name', Field::TEXT, [
                'rules' => 'required',
                'label' => "Nick name"
            ])
            ->add('icon', Field::BUTTON_BUTTON, [
                'attr' => ['class' => 'btn btn-secondary iconButton', 'id' => 'icon', 'role' => 'iconpicker', 'data-icon' => (!empty($this->getData('icon')) ? $this->getData('icon') : "")],
            ])
            ->add('history', Field::NUMBER, [
                'rules' => 'required',
                'label' => "History"
            ])
            ->add('units', Field::TEXT, [
                'rules' => 'required',
                'label' => "Units"
            ])
            ->add('room_id', Field::SELECT, [
                'choices' => (!empty($this->getData('rooms')) ? $this->getData('rooms') : array(0 => "Nothing")),
                'rules' => 'required',
                'label' => "Room"
            ])
            ->add('saveProfile', Field::BUTTON_SUBMIT, [
                'label' => __('simplehome.save')
            ]);
    }
}
