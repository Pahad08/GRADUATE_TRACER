<?php

namespace App\Livewire\TracerComponents;

use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

class TrackingForm extends Component
{
    #[Locked]
    public $civil_status_selection = ['single', 'married', 'separated', 'widow or widower', 'single parent'];

    public $childComponents = [
        'tracer-components.general-information' => [
            'icon' => 'fa-user',
            'title' => 'General Information',
        ],
        'tracer-components.educational-background' => [
            'icon' => 'fa-user-graduate',
            'title' => 'Educational Background',
        ],
        'tracer-components.studies-information' => [
            'icon' => 'fa-certificate',
            'title' => 'Training/Advance Studies',
        ],
        'tracer-components.employment-data' => [
            'icon' => 'fa-user-tie',
            'title' => 'Employement Data',
        ]
    ];

    public $activeTab = "tracer-components.general-information";

    #[On('generalInformationError')]
    public function generalInformationError() {}

    public function save()
    {
        // $this->dispatch('form-submitted');
    }

    #[On('general_information_validated')]
    public function general_information_validated($general_information)
    {
        // dd($general_information);
    }

    #[Title('Graduate Tracer')]
    public function render()
    {
        return view('livewire.index');
    }
}