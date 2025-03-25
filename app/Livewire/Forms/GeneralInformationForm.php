<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;

class GeneralInformationForm extends Form
{
    public $f_name;
    public $l_name;
    public $permanent_address;
    public $email_address;
    public $contact_number;
    public $sex;
    public $civil_status;
    public $birthdate;
    public $region_id;
    public $province_id;
    // public $location_of_residence;
    public $city;

    protected function rules()
    {
        $civil_status_selection = ['single', 'married', 'separated', 'widow or widower', 'single parent'];

        return [
            'f_name' => [
                'required',
            ],
            'l_name' => [
                'required',
            ],
            'permanent_address' => [
                'required',
            ],
            'email_address' => [
                'required',
                'email'
            ],
            'contact_number' => [
                'required',
            ],
            'sex' => [
                'required',
                Rule::in(['male', 'female'])
            ],
            'civil_status' => [
                'required',
                Rule::in(array_keys($civil_status_selection))
            ],
            'birthdate' => [
                'required',
                'date'
            ],
            'region_id' => [
                'required',
                'exists:regions'
            ],
            'province_id' => [
                'required',
                'exists:provinces'
            ],
            // 'location_of_residence' => [
            //     'required',
            //     Rule::in(['city', 'municipality'])
            // ],
            // 'city' => []
        ];
    }
}