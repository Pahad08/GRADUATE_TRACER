<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;

class GeneralInformationForm extends Form
{
    public $f_name = 'fahad';
    public $l_name = 'bagundang';
    public $permanent_address = 'tacurong city';
    public $email_address = 'fahad@gmail.com';
    public $contact_number = '32131313';
    public $sex = 'male';
    public $civil_status = 'single';
    public $birthdate = '1999-01-01';
    public $region_id = 1;
    public $province_id = 1;
    public $location_of_residence = 'city';
    // public $city;

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
            'region_id' => [
                'sometimes',
                'required',
                'exists:regions'
            ],
            'province_id' => [
                'sometimes',
                'required',
                'exists:provinces'
            ],
            'location_of_residence' => [
                'sometimes',
                'required',
                Rule::in(['city', 'municipality'])
            ],
            // 'city' => []
        ];
    }
}
