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
        'checkboxes' => ['For promotion']
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
            // dispatch an event to add studies information error
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
            $rules["reasons_for_study.checkboxes.*"] = 'sometimes|required';
            $rules["reasons_for_study.input"] = 'sometimes|required';
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

            $training_rules["$prefix.training_name"] = 'sometimes|required';
            $training_rules["$prefix.duration_and_credits_earned"] = 'sometimes|required';
            $training_rules["$prefix.training_institution"] = 'sometimes|required';
        }

        if (empty($training_rules)) {
            $training_rules["trainings.0.training_name"] = 'sometimes|required';
            $training_rules["trainings.0.duration_and_credits_earned"] = 'sometimes|required';
            $training_rules["trainings.0.training_institution"] = 'sometimes|required';
        }

        $rules = array_merge($rules, $training_rules);

        return $rules;
    }

    #[On('form-submitted')]
    public function validateStudiesInformation()
    {
        try {
            $this->validate();
            $this->dispatch('validated-studies-information', studies_information: $this->all());
            // dispatch an event to send the validated studies information
            $this->dispatch('studies-error', [
                'studies_errors' => []
            ]);
        } catch (ValidationException $e) {
            // dispatch an event to add studies information error
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
        $this->trainings[] = ['training_name' => 'dadad', 'duration_and_credits_earned' => '12', 'training_institution' => 'dasdad'];
    }

    public function render()
    {
        return view('livewire.forms.studies-information');
    }
}
