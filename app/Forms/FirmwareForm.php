<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Validation\Rule;

class FirmwareForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('firmware', Field::FILE, [
                'wrapper' => ['class' => 'd-flex justify-content-between ml-auto', 'for' => 'firmware'],
                'label_attr' => ['class' => 'fas fa-arrow-circle-up', 'aria-hidden' => "true"],
                'label' => " ",
                'attr' => ['id' => 'firmware', 'style' => 'display:none', 'onchange' => 'this.form.submit();'],
                'rules' => 'required'
            ])
            ->add('id', Field::HIDDEN, [
                'rules' => 'required'
            ]);
    }
}
