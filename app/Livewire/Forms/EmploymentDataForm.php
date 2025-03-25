<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class EmploymentDataForm extends Form
{
    public $is_employed = '';
    public $reason = ['input' => '', 'checkboxes' => []];
    public $employment_status = '';
    public $present_occupation = '';
    public $suggestions = [''];

    public function validateSuggestion()
    {
        $this->validate([
            'suggestions.*' => 'required',
        ]);
    }
}