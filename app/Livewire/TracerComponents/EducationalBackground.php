<?php

namespace App\Livewire\TracerComponents;

use App\Models\CustomQuestion;
use App\Models\Degree;
use App\Models\HEI;
use App\Models\QuestionVisibility;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EducationalBackground extends Component
{

    public $educational_attainment = [];
    public $professional_examination = [];
    public $reasons_for_undergraduate = [];
    public $reasons_for_graduate = [];
    public $reason_options = [
        "High grades in the course or subject area(s) related to the course",
        "Good grades in high school",
        "Influence of parents or relatives",
        "Peer Influence",
        "Inspired by a role model",
        "Strong passion for the profession",
        "Prospect for immediate employment",
        "Status or prestige of the profession",
        "Availability of course offering in chosen institution",
        "Prospect of career advancement",
        "Affordable for the family",
        "Prospect of attractive compensation",
        "Opportunity for employment abroad",
        "No particular choice or no better idea",
    ];
    public $custom_questions = [];

    public function updatedEducationalAttainment($value, $key)
    {
        $exploded_key = explode('.', $key);
        $index = $exploded_key[0];
        $key = $exploded_key[1];

        if ($key === 'search_degree') {
            if (empty($this->educational_attainment[$index]['search_degree'])) {
                $this->educational_attainment[$index]['degree_result'] = Degree::all();
                return;
            }
            $this->educational_attainment[$index]['degree_result'] = Degree::where('degree_name', 'like', '%' .
                $this->educational_attainment[$index]['search_degree'] . '%')->get();
        } elseif ($key === 'search_hei') {
            if (empty($this->educational_attainment[$index]['search_hei'])) {
                $this->educational_attainment[$index]['hei_result'] = HEI::all();
                return;
            }
            $this->educational_attainment[$index]['hei_result'] = HEI::where('hei_name', 'like', '%' .
                $this->educational_attainment[$index]['search_hei'] . '%')->get();
        }
    }

    public function selectDegree($key, $id, $degree_name)
    {
        $this->educational_attainment[$key]['degree_id'] = $id;
        $this->educational_attainment[$key]['search_degree'] = $degree_name;
        $this->educational_attainment[$key]['degree_result'] = Degree::where('degree_name', $degree_name)->get();
    }

    public function selectHEI($key, $id, $hei_name)
    {
        $this->educational_attainment[$key]['hei_id'] = $id;
        $this->educational_attainment[$key]['search_hei'] = $hei_name;
        $this->educational_attainment[$key]['hei_result'] = HEI::where('hei_name', $hei_name)->get();;
    }

    protected function messages()
    {
        return [
            'reasons_for_undergraduate.checkboxes' => 'Provide atleast one reason',
            'reasons_for_undergraduate.input' => 'Provide atleast one reason',
            'reasons_for_graduate.checkboxes' => 'Provide atleast one reason',
            'reasons_for_graduate.input' => 'Provide atleast one reason',
        ];
    }

    protected function rules()
    {
        $educationalAttainmentRules = [];
        $professionalExaminationRules = [];
        $rules = [];

        if (
            empty($this->reasons_for_graduate['input']) && empty($this->reasons_for_graduate['checkboxes']) &&
            empty($this->reasons_for_undergraduate['input']) && empty($this->reasons_for_undergraduate['checkboxes'])
        ) {
            $rules["reasons_for_graduate.checkboxes.*"] = 'sometimes|required';
            $rules["reasons_for_graduate.input"] = 'sometimes|required';
        }

        if (!empty($this->reasons_for_graduate['checkboxes']) || !empty($this->reasons_for_graduate['input'])) {
            $rules["reasons_for_undergraduate.checkboxes.*"] = 'nullable';
            $rules["reasons_for_undergraduate.input"] = 'nullable';
        }

        if (!empty($this->reasons_for_undergraduate['checkboxes']) || !empty($this->reasons_for_undergraduate['input'])) {
            $rules["reasons_for_graduate.checkboxes.*"] = 'nullable';
            $rules["reasons_for_graduate.input"] = 'nullable';
        }

        foreach ($this->educational_attainment as $key => $value) {
            $prefix = "educational_attainment.$key";

            $educationalAttainmentRules["$prefix.degree_id"] = 'sometimes|required|exists:degrees,degree_id';
            $educationalAttainmentRules["$prefix.hei_id"] = 'sometimes|required|exists:hei,hei_id';
            $educationalAttainmentRules["$prefix.year_graduated"] = ['sometimes', 'required', 'integer', 'digits:4', 'max:' . date('Y')];
            $educationalAttainmentRules["$prefix.honor.*"] = 'nullable';
        }

        foreach ($this->professional_examination as $key => $value) {
            if ($key === 0) {
                continue;
            }

            $prefix = "professional_examination.$key";

            $professionalExaminationRules["$prefix.name_of_examination"] = 'sometimes|nullable';
            $professionalExaminationRules["$prefix.date_taken"] = 'sometimes|nullable|date';
            $professionalExaminationRules["$prefix.rating"] = 'sometimes|nullable';
        }

        $mergedValidationRules = array_merge($educationalAttainmentRules, $professionalExaminationRules);

        if (empty($mergedValidationRules)) {
            $rules["professional_examination.0.name_of_examination"] = 'sometimes|nullable';
            $rules["professional_examination.0.date_taken"] = 'sometimes|nullable|date';
            $rules["professional_examination.0.rating"] = 'sometimes|nullable';

            $rules["educational_attainment.0.degree_id"] = 'sometimes|required|exists:degrees,degree_id';
            $rules["educational_attainment.0.hei_id"] = 'sometimes|required|exists:hei,hei_id';
            $rules["educational_attainment.0.year_graduated"] = 'sometimes|required|numeric|digits:4|min:1900|max:2100';
            $rules["educational_attainment.0.honor"] = 'nullable';

            $rules["custom_questions.*"] = [
                'sometimes',
                Rule::requiredIf(count($this->custom_questions) > 0)
            ];

            return $rules;
        }

        if (empty($educationalAttainmentRules)) {
            $rules["educational_attainment.0.degree_id"] = 'sometimes|required|exists:degrees,degree_id';
            $rules["educational_attainment.0.hei_id"] = 'sometimes|required|exists:hei,hei_id';
            $rules["educational_attainment.0.year_graduated"] = 'sometimes|required|numeric|digits:4|min:1900|max:2100';
            $rules["educational_attainment.0.honor.*"] = 'nullable';
        }

        if (empty($professionalExaminationRules)) {
            $rules["professional_examination.0.name_of_examination"] = 'sometimes|nullable';
            $rules["professional_examination.0.date_taken"] = 'sometimes|nullable|date';
            $rules["professional_examination.0.rating"] = 'sometimes|nullable';
        }

        $rules["custom_questions.*"] = [
            'sometimes',
            Rule::requiredIf(count($this->custom_questions) > 0)
        ];

        return array_merge($rules, $mergedValidationRules);
    }

    public function addEducationAttainmentRow()
    {
        $this->educational_attainment[] = ['degree_id' => '', 'hei_id' => '', 'year_graduated' => '', 'honor' => ['']];
    }

    public function addProfessionalExaminationRow()
    {
        try {
            $this->validate([
                'professional_examination.*.name_of_examination' => 'required',
                'professional_examination.*.date_taken' => 'required|date',
                'professional_examination.*.rating' => 'required'
            ]);

            $this->professional_examination[] = [
                'name_of_examination' => $this->professional_examination[0]['name_of_examination'],
                'date_taken' =>  $this->professional_examination[0]['date_taken'],
                'rating' =>  $this->professional_examination[0]['rating'],
            ];
            $this->professional_examination[0] = ['name_of_examination' => '', 'date_taken' => '', 'rating' => '',];
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();

            foreach ($this->professional_examination as $index => $examination) {
                foreach (array_keys($examination) as $field) {
                    $fieldKey = "professional_examination.$index.$field";

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
        }
    }

    public function deleteEducationAttainmentRow($index)
    {
        unset($this->educational_attainment[$index]);
        $this->educational_attainment = array_values($this->educational_attainment);
    }

    public function deleteProfessionalExaminationRow($index)
    {
        unset($this->professional_examination[$index]);
        $this->professional_examination = array_values($this->professional_examination);
    }

    #[On('form-submitted')]
    public function validateEducationalBackground()
    {
        try {
            $this->validate();
            // dispatch an event to the tracking form parent
            $this->dispatch('validated-education-background', educational_background: $this->except(['reason_options']));
            // dispatch an event to clear the errors
            $this->dispatch('educational-background-error', [
                'educational_background_tab' => ''
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();

            //reset educational attainment if no errors
            foreach ($this->educational_attainment as $index => $examination) {
                foreach (array_keys($examination) as $field) {
                    $fieldKey = "educational_attainment.$index.$field";

                    // Only reset if it's not in the current validation error array
                    if (!array_key_exists($fieldKey, $errors)) {
                        $this->resetValidation($fieldKey);
                    }
                }
            }

            //reset professional examination if no errors
            foreach ($this->professional_examination as $index => $examination) {
                foreach (array_keys($examination) as $field) {
                    $fieldKey = "professional_examination.$index.$field";

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
            $this->dispatch('educational-background-error', [
                'educational_background_tab' => 'tracer-components.educational-background',
            ]);
        }
    }

    #[On('graduate-created')]
    public function resetEducationalBackground()
    {
        $this->reasons_for_undergraduate = [
            'input' => '',
            'checkboxes' => []
        ];

        $this->reasons_for_graduate = [
            'input' => '',
            'checkboxes' => []
        ];

        $this->educational_attainment = [];
        $this->educational_attainment[] = [
            'search_degree' => '',
            'degree_result' => Degree::all(),
            'search_hei' => '',
            'hei_result' => HEI::all(),
            'degree_id' => '',
            'hei_id' => '',
            'year_graduated' => '',
            'honor' => ['']
        ];

        $this->professional_examination = array_slice($this->professional_examination, 0, 1);

        $questions = CustomQuestion::with(['questionVisibility', 'questionOption'])
            ->whereHas('questionVisibility', function ($query) {
                $query->where('section_name', 'EDUCATIONAL_BACKGROUND')
                    ->where('is_visible', true);
            })
            ->get();

        $this->custom_questions = $questions->mapWithKeys(function ($question) {
            $key = Str::slug($question->label, '_');

            $value = $question->questionOption->isNotEmpty() ? [] : '';

            return [$key => $value];
        })->toArray();
    }

    #[Computed()]
    public function questionVisibility()
    {
        return QuestionVisibility::with('question.questionOption')->where('section_name', 'EDUCATIONAL_BACKGROUND')
            ->where('is_visible', true)->orderBy('question_order')->get();
    }

    public function addHonor($key)
    {
        try {
            $this->validate([
                'educational_attainment.' . $key . '.honor.0' => 'required',

            ]);
            $this->educational_attainment[$key]['honor'][] = $this->educational_attainment[$key]['honor'][0];
            $this->educational_attainment[$key]['honor'][0] = '';
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

    public function removeHonor($key, $honor_key)
    {
        if (!isset($this->educational_attainment[$key]['honor'][$honor_key])) {
            return;
        }
        unset($this->educational_attainment[$key]['honor'][$honor_key]);
    }

    public function removeRow($key)
    {
        if (!isset($this->educational_attainment[$key])) {
            return;
        }
        unset($this->educational_attainment[$key]);
    }

    public function mount()
    {
        $this->reasons_for_undergraduate = [
            'input' => '',
            'checkboxes' => []
        ];

        $this->reasons_for_graduate = [
            'input' => '',
            'checkboxes' => []
        ];

        $this->educational_attainment[] = [
            'search_degree' => '',
            'degree_result' => Degree::all(),
            'search_hei' => '',
            'hei_result' => HEI::all(),
            'degree_id' => '',
            'hei_id' => '',
            'year_graduated' => '',
            'honor' => ['']
        ];

        $this->professional_examination[] = ['name_of_examination' => '', 'date_taken' => '', 'rating' => '',];

        $questions = CustomQuestion::with(['questionVisibility', 'questionOption'])
            ->whereHas('questionVisibility', function ($query) {
                $query->where('section_name', 'EDUCATIONAL_BACKGROUND')
                    ->where('is_visible', true);
            })
            ->get();

        $this->custom_questions = $questions->mapWithKeys(function ($question) {
            $key = Str::slug($question->label, '_');

            $value = $question->questionOption->isNotEmpty() ? [] : '';

            return [$key => $value];
        })->toArray();
    }

    public function render()
    {

        return view('livewire.forms.educational-background');
    }
}