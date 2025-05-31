<?php

namespace App\Livewire\Forms;


use Illuminate\Validation\Rule;
use Livewire\Form;

class GeneralInformationForm extends Form
{
    public $f_name = '';
    public $name_extension = '';
    public $l_name = '';
    public $permanent_address = '';
    public $email_address = '';
    public $contact_number = '';
    public $sex = '';
    public $civil_status = '';
    public $birthdate = '';
    public $region = 'REGION 12';
    public $province = '';
    public $location_of_residence = '';
    public $custom_questions = [];

    protected function rules()
    {
        $civil_status_selection = ['single', 'married', 'separated', 'widow or widower', 'single parent'];
        $provinces = [
            'SULTAN KUDARAT',
            'SOUTH COTABATO',
            'SARANGANI',
            'COTABATO',
        ];

        return [
            'f_name' => [
                'sometimes',
                'required',
            ],
            'l_name' => [
                'sometimes',
                'required',
            ],
            'name_extension' => [
                'nullable',
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
                'regex:/^(09|\+639)\d{9}$/'
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
            ],
            'province' => [
                'sometimes',
                'required',
                Rule::in($provinces)
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

    protected function messages()
    {
        return [
            'f_name.required' => 'The First name are required.',
            'l_name.required' => 'The Last name is required.',
            'permanent_address.required' => 'The Permanent address is required.',
            'email_address.required' => 'The Email address is required.',
            'email_address.email' => 'The Email address must be a valid email address.',
            'contact_number.required' => 'The Contact number is required.',
            'contact_number.regex' => 'The Contact number must be a valid mobile number.',
            'sex.required' => 'The Sex is required.',
            'civil_status.required' => 'The Civil status is required.',
            'birthdate.required' => 'The Birthdate is required.',
            'region.required' => 'The Region is required.',
            'province.required' => 'The Province is required.',
            'location_of_residence.required' => 'The Location of residence is required.',
            'custom_questions.*.required' => 'This field is required.',
        ];
    }
}