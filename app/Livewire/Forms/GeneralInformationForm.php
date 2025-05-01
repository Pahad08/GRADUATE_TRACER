<?php

namespace App\Livewire\Forms;


use Illuminate\Validation\Rule;
use Livewire\Form;

class GeneralInformationForm extends Form
{
    public $f_name = '';
    public $l_name = '';
    public $permanent_address = '';
    public $email_address = '';
    public $contact_number = '';
    public $sex = '';
    public $civil_status = '';
    public $birthdate = '';
    public $region = '';
    public $province = '';
    public $location_of_residence = '';
    public $custom_questions = [];

    protected function rules()
    {
        $civil_status_selection = ['single', 'married', 'separated', 'widow or widower', 'single parent'];

        return [
            'f_name' => [
                'sometimes',
                'required',
            ],
            'l_name' => [
                'sometimes',
                'required',
            ],
            'permanent_address' => [
                'sometimes',
                'required',
            ],
            'email_address' => [
                'sometimes',
                'required',
                'email'
            ],
            'contact_number' => [
                'sometimes',
                'required',
            ],
            'sex' => [
                'sometimes',
                'required',
                Rule::in(['male', 'female'])
            ],
            'civil_status' => [
                'sometimes',
                'required',
                Rule::in($civil_status_selection)
            ],
            'birthdate' => [
                'sometimes',
                'required',
                'date'
            ],
            'region' => [
                'sometimes',
                'required',
                'exists:regions,region_id'
            ],
            'province' => [
                'sometimes',
                'required',
                'exists:provinces,province_id'
            ],
            'location_of_residence' => [
                'sometimes',
                'required',
                Rule::in(['city', 'municipality'])
            ],
            'custom_questions.*' => [
                'sometimes',
                Rule::requiredIf(count($this->custom_questions) > 0),
            ]
        ];
    }
}
