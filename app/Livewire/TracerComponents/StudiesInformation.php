<?php

namespace App\Livewire\TracerComponents;

use App\Models\CustomQuestion;
use App\Models\QuestionVisibility;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class StudiesInformation extends Component
{
    public $trainings = [];
    public $custom_questions = [];
    public $reasons_for_study = [];

    public function addTrainingRow()
    {
        try {
            $this->validate([
                'trainings.*.training_name' => 'required',
                'trainings.*.duration_and_credits_earned' => 'required',
                'trainings.*.training_institution' => 'required',
            ]);

            $this->trainings[] = [
                'training_name' => $this->trainings[0]['training_name'],
                'duration_and_credits_earned' =>  $this->trainings[0]['duration_and_credits_earned'],
                'training_institution' =>  $this->trainings[0]['training_institution'],
            ];
            $this->trainings[0] = ['training_name' => '', 'duration_and_credits_earned' => '', 'training_institution' => ''];
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();

            // loop errors and add them to the component
            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    $this->addError($field, $message);
                }
            }
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

            $training_rules["$prefix.training_name"] = 'sometimes|nullable';
            $training_rules["$prefix.duration_and_credits_earned"] = 'sometimes|nullable';
            $training_rules["$prefix.training_institution"] = 'sometimes|nullable';
        }

        if (empty($training_rules)) {
            $training_rules["trainings.0.training_name"] = 'sometimes|nullable';
            $training_rules["trainings.0.duration_and_credits_earned"] = 'sometimes|nullable';
            $training_rules["trainings.0.training_institution"] = 'sometimes|nullable';
        }

        $rules = array_merge($rules, $training_rules);

        $rules["custom_questions.*"] = [
            'sometimes',
            Rule::requiredIf(count($this->custom_questions) > 0)
        ];

        return $rules;
    }

    #[On('form-submitted')]
    public function validateStudiesInformation()
    {
        try {
            $this->validate();

            $this->dispatch('validated-studies-information', studies_information: $this->all());

            $this->dispatch('studies-error', [
                'studies_tab' => '',
            ]);
        } catch (ValidationException $e) {
            // $this->resetValidation();
            $errors = $e->validator->errors()->toArray();

            //reset trainings if no errors
            foreach ($this->trainings as $index => $training) {
                foreach (array_keys($training) as $field) {
                    $fieldKey = "trainings.$index.$field";

                    // Only reset if it's not in the current validation error array
                    if (!array_key_exists($fieldKey, $errors)) {
                        $this->resetValidation($fieldKey);
                    }
                }
            }

            // loop errors and add them to the component
            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    $this->addError($field, $message);
                }
            }

            // dispatch an event to add general information error
            $this->dispatch('studies-error', [
                'studies_tab' => 'tracer-components.studies-information',
            ]);
        }
    }

    #[On('graduate-created')]
    public function resetStudiesInformation()
    {
        $this->reset(['reasons_for_study']);
        $this->trainings = array_slice($this->trainings, 0, 1);
        $this->reasons_for_study =   ['input' => '', 'checkboxes' => []];

        $questions = CustomQuestion::with(['questionVisibility', 'questionOption'])
            ->whereHas('questionVisibility', function ($query) {
                $query->where('section_name', 'TRAININGS_STUDIES')->where('is_visible', true);
            })->get();

        $this->custom_questions = $questions->mapWithKeys(function ($question) {
            $key = Str::slug($question->label, '_');

            $value = $question->questionOption->isNotEmpty() ? [] : '';

            return [$key => $value];
        })->toArray();
    }

    #[Computed()]
    public function questionVisibility()
    {
        return QuestionVisibility::with('question.questionOption')->where('section_name', 'TRAININGS_STUDIES')
            ->where('is_visible', true)->orderBy('question_order')->get();
    }

    public function mount()
    {
        $this->trainings[] = ['training_name' => '', 'duration_and_credits_earned' => '', 'training_institution' => ''];

        $this->reasons_for_study =   ['input' => '', 'checkboxes' => []];

        $questions = CustomQuestion::with(['questionVisibility', 'questionOption'])
            ->whereHas('questionVisibility', function ($query) {
                $query->where('section_name', 'TRAININGS_STUDIES')->where('is_visible', true);
            })->get();

        $this->custom_questions = $questions->mapWithKeys(function ($question) {
            $key = Str::slug($question->label, '_');

            $value = $question->questionOption->isNotEmpty() ? [] : '';

            return [$key => $value];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.forms.studies-information');
    }
}