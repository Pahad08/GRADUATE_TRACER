<?php

namespace App\Livewire\TracerComponents;

use App\Livewire\Forms\GeneralInformationForm;
use Livewire\Component;
use App\Models\Province;
use App\Models\QuestionVisibility;
use App\Models\Region;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\CustomQuestion;
use Illuminate\Support\Str;

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
                'general_information_tab' => '',
            ]);
        } catch (ValidationException $e) {
            $this->resetValidation();
            $errors = $e->validator->errors()->toArray();

            // loop errors and add them to the component
            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    $this->addError($field, $message);
                }
            }

            // dispatch an event to add general information error
            $this->dispatch('general-information-error', [
                'general_information_tab' => 'tracer-components.general-information',
            ]);
        }
    }

    #[On('graduate-created')]
    public function resetGeneralInformation()
    {
        $this->form->reset();
    }

    #[Computed]
    public function questionVisibility()
    {
        return QuestionVisibility::with('question.questionOption')->where('section_name', 'GENERAL_INFORMATION')
            ->where('is_visible', true)->orderBy('question_order')->get();
    }

    public function mount()
    {
        $questions = CustomQuestion::with(['questionVisibility', 'questionOption'])
            ->whereHas('questionVisibility', function ($query) {
                $query->where('section_name', 'GENERAL_INFORMATION')->where('is_visible', true);
            })
            ->get();

        $this->form->custom_questions = $questions->mapWithKeys(function ($question) {
            $key = Str::slug($question->label, '_');

            $value = $question->questionOption->isNotEmpty() ? [] : '';

            return [$key => $value];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.forms.general-information');
    }
}