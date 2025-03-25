<?php

namespace App\Livewire\TracerComponents;

use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class StudiesInformation extends Component
{

    public $trainings = [];
    public $reasons_for_study = [
        'input' => '',
        'checkboxes' => []
    ];

    public function addTrainingRow()
    {
        try {
            $this->validate([
                'trainings.*.training_name' => 'required',
                'trainings.*.duration_and_credits_earned' => 'required',
                'trainings.*.training_institution' => 'required',
            ]);

            $this->dispatch(
                'trainings-error',
                []
            );

            $this->trainings[] = [
                'training_name' => $this->trainings[0]['training_name'],
                'duration_and_credits_earned' =>  $this->trainings[0]['duration_and_credits_earned'],
                'training_institution' =>  $this->trainings[0]['training_institution'],
            ];
            $this->trainings[0] = ['training_name' => '', 'duration_and_credits_earned' => '', 'training_institution' => ''];
        } catch (ValidationException $e) {
            // dispatch an event to add educational attainment error
            $this->dispatch(
                'trainings-error',
                $e->validator->errors()
            );
        }
    }

    protected function messages()
    {
        return [
            'reasons_for_study.checkboxes' => 'Provide atleast one reason',
            'reasons_for_study.input' => 'Provide atleast one reason',
        ];
    }

    public function removeTrainingRow($index)
    {
        unset($this->trainings[$index]);
        $this->trainings = array_values($this->trainings);
    }

    protected function rules()
    {
        $training_rules = [];
        $rules = [];

        if (empty($this->reasons_for_study['input']) && empty($this->reasons_for_study['checkboxes'])) {
            $rules["reasons_for_study.checkboxes.*"] = 'required';
            $rules["reasons_for_study.input"] = 'required';
        }

        if (!empty($this->reasons_for_study['checkboxes']) || !empty($this->reasons_for_study['input'])) {
            $rules["reasons_for_study.checkboxes.*"] = 'nullable';
            $rules["reasons_for_study.input"] = 'nullable';
        }

        foreach ($this->trainings as $key => $value) {
            if ($key === 0) {
                continue;
            }
            $prefix = "trainings.$key";

            $training_rules["$prefix.training_name"] = 'required';
            $training_rules["$prefix.duration_and_credits_earned"] = 'required';
            $training_rules["$prefix.training_institution"] = 'required';
        }

        if (empty($training_rules)) {
            $training_rules["trainings.0.training_name"] = 'required';
            $training_rules["trainings.0.duration_and_credits_earned"] = 'required';
            $training_rules["trainings.0.training_institution"] = 'required';
        }

        $rules = array_merge($rules, $training_rules);

        return $rules;
    }

    #[On('form-submitted')]
    public function validateEducationalBackground()
    {
        try {
            $this->validate();
            $this->dispatch('studies-validated');
            // dispatch an event to send the validated educational background
            $this->dispatch('studies-error', [
                'studies_tab' => 'tracer-components.studies-information',
                'studies_errors' => []
            ]);
        } catch (ValidationException $e) {
            // dispatch an event to add educational background error
            $this->dispatch('studies-error', [
                'studies_tab' => 'tracer-components.studies-information',
                'studies_errors' => $e->validator->errors()
            ]);
        } finally {
            $this->skipRender();
        }
    }

    public function mount()
    {
        $this->trainings[] = ['training_name' => '', 'duration_and_credits_earned' => '', 'training_institution' => ''];
    }

    public function render()
    {
        return view('livewire.forms.studies-information');
    }
}