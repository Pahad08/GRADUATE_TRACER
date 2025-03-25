<?php

namespace App\Livewire\TracerComponents;

use App\Livewire\Forms\EmploymentDataForm;
use Livewire\Attributes\Locked;
use Livewire\Component;

class EmploymentData extends Component
{
    public EmploymentDataForm $form;

    #[Locked]
    public $occupations = [
        "Officials of Government and Special-Interest Organizations, Corporate Executives, Managers, Managing Proprietors and Supervisors",
        "Professionals",
        "Technicians and Associate Professionals",
        "Clerks",
        "Service Workers and Shop and Market Sales Workers",
        "Farmers, Forestry Workers and Fishermen",
        "Trades and Related Workers",
        "Plant and Machine Operators and Assemblers",
        "Laborers and Unskilled Workers",
        "Special Occupation"
    ];

    public function save()
    {
        // $this->dispatch('form-submitted');
    }

    public function addSuggestionInput()
    {
        $this->form->validateSuggestion();
        $this->form->suggestions[] = $this->form->suggestions[0];
        $this->form->suggestions[0] = '';
    }

    public function deleteSuggestionInput($index)
    {
        unset($this->form->suggestions[$index]);
        $this->form->suggestions = array_values($this->form->suggestions);
    }

    public function render()
    {
        return view('livewire.forms.employment-data');
    }
}