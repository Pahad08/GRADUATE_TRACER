<?php

namespace App\Livewire\TracerComponents;

use App\Livewire\Forms\GeneralInformationForm;
use Livewire\Component;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;

class GeneralInformation extends Component
{
    public $civil_status_selection = ['single', 'married', 'separated', 'widow or widower', 'single parent'];

    public GeneralInformationForm $form;
    public $name = '';
    public $activeTab;

    #[On('form-submitted')]
    public function generalInformationValidated()
    {

        try {
            $this->validate();
            // dispatch an event to send the validated general information
            $this->dispatch('validated-general-information', general_information: $this->form->all());

            // dispatch an event to remove general information error
            $this->dispatch('general-information-error', [
                'general_information_errors' => []
            ]);
        } catch (ValidationException $e) {
            // dispatch an event to add general information error
            $this->dispatch('general-information-error', [
                'general_information_tab' => 'tracer-components.general-information',
                'general_information_errors' => $e->validator->errors()
            ]);
        } finally {
            $this->skipRender();
        }
    }


    public function render()
    {
        return view('livewire.forms.general-information', [
            'provinces' => Province::all(),
            'regions' => Region::all(),
        ]);
    }
}
