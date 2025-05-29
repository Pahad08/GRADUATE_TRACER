<?php

namespace App\Livewire\Admin;

use App\Models\CustomQuestion;
use App\Models\QuestionVisibility;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Questions extends Component
{

    public $sections = [
        'admin.questions.general-information' => [
            'icon' => 'fa-user',
            'title' => 'General Information',
        ],
        'admin.questions.educational-background' =>  [
            'icon' => 'fa-user-graduate',
            'title' => 'Educational Background',
        ],
        'admin.questions.training-advance-studies' => [
            'icon' => 'fa-certificate',
            'title' => 'Training/Advance Studies',
        ],
        'admin.questions.employment-data' => [
            'icon' => 'fa-user-tie',
            'title' => 'Employment Data',
        ]
    ];
    public $option_inputs = [];
    public $label;
    public $section;
    public $type;

    public function addOptionvalue()
    {
        try {
            $this->validate([
                'option_inputs.*.option_text' => 'required',
                'option_inputs.*.option_value' => 'required',
            ]);
            $this->option_inputs[] = ['option_text' => $this->option_inputs[0]['option_text'], 'option_value' => $this->option_inputs[0]['option_value']];
            $this->option_inputs[0] = ['option_text' => '', 'option_value' => ''];
        } catch (ValidationException $e) {
            $this->resetValidation();
            $errors = $e->validator->errors()->toArray();

            // loop errors and add them to the component
            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    $this->addError($field, $message);
                }
            }
        }
    }

    public function removeOptionvalue($index)
    {
        unset($this->option_inputs[$index]);
        $this->option_inputs = array_values($this->option_inputs);
    }

    public function saveCustomQuestion()
    {

        $rules = [
            'label' => 'required',
            'section' => ['required', Rule::in(['GENERAL_INFORMATION', 'EDUCATIONAL_BACKGROUND', 'TRAININGS_STUDIES', 'EMPLOYMENT_DATA'])],
            'type' => ['required', Rule::in(['text', 'date', 'checkbox', 'number', 'radio', 'select'])],
        ];

        foreach ($this->option_inputs as $key => $value) {
            if ($key === 0) {
                continue;
            }
            $prefix = "option_inputs.$key";

            $rules["$prefix.option_text"] = ['sometimes', 'sometimes', Rule::requiredIf(in_array($this->type, ['radio', 'select', 'checkbox']) && !empty($this->type))];
            $rules["$prefix.option_value"] = ['sometimes', 'sometimes', Rule::requiredIf(in_array($this->type, ['radio', 'select', 'checkbox']) && !empty($this->type))];
        }

        $validated = $this->validate($rules);

        DB::transaction(function () use ($validated) {
            $separate_section = explode('_', $validated['section']);
            $separate_label = str_replace(' ', '_', $validated['label']);
            $prefix = strtoupper($separate_section[0][0]) . strtoupper($separate_section[1][0]);
            $generated_key = $prefix . '-' . $separate_label;
            $section_count = QuestionVisibility::where('section_name', $validated['section'])->count();

            $question_visibility = QuestionVisibility::create([
                'section_name' => $validated['section'],
                'question_key' => $generated_key,
                'is_visible' => true,
                'question_order' => $section_count + 1,
            ]);

            $question = $question_visibility->question()->create([
                'type' => $validated['type'],
                'label' => $validated['label'],
                'has_child' => isset($validated['option_inputs']),
            ]);

            if (isset($validated['option_inputs'])) {
                $question->questionOption()->createMany($validated['option_inputs']);
            }

            $this->dispatch('question-created', 'Question created!');
            $this->reset();
        });
    }

    public function removeQuestion($key)
    {
        QuestionVisibility::where('question_key', $key)->delete();
        $this->dispatch('question-removed', $key);
    }

    public function mount()
    {
        $this->option_inputs[] = ['option_text' => '', 'option_value' => ''];
    }

    public function render()
    {
        return view('livewire.admin.questions');
    }
}