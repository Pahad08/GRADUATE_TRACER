<?php

namespace App\Livewire\TracerComponents;

use App\Models\Degree;
use App\Models\University;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\On;

class EducationalBackground extends Component
{

    public $educational_attainment = [];
    public $professional_examination = [];
    public $type = 'undergraduate';
    public $reasons = [
        'input' => '',
        'checkboxes' => ['Good grades in high school']
    ];
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

    public function mount()
    {
        $this->educational_attainment[] = ['degree_id' => '', 'university_id' => '', 'year_graduated' => '', 'honor' => ''];
        $this->educational_attainment[] = ['degree_id' => '1', 'university_id' => '1', 'year_graduated' => '1999', 'honor' => '2121'];

        $this->professional_examination[] = ['name_of_examination' => '', 'date_taken' => '', 'rating' => '',];
        $this->professional_examination[] = ['name_of_examination' => 'dasdad', 'date_taken' => '1999-01-01', 'rating' => '99',];
    }

    protected function messages()
    {
        return [
            'reasons.checkboxes' => 'Provide atleast one reason',
            'reasons.input' => 'Provide atleast one reason',
        ];
    }

    protected function rules()
    {
        $educationalAttainmentRules = [];
        $professionalExaminationRules = [];
        $rules = [];

        if (empty($this->reasons['input']) && empty($this->reasons['checkboxes'])) {
            $rules["reasons.checkboxes.*"] = 'sometimes|required';
            $rules["reasons.input"] = 'sometimes|required';
        }

        if (!empty($this->reasons['checkboxes']) || !empty($this->reasons['input'])) {
            $rules["reasons.checkboxes.*"] = 'nullable';
            $rules["reasons.input"] = 'nullable';
        }

        foreach ($this->educational_attainment as $key => $value) {
            if ($key === 0) {
                continue;
            }
            $prefix = "educational_attainment.$key";

            $educationalAttainmentRules["$prefix.degree_name"] = 'sometimes|required';
            $educationalAttainmentRules["$prefix.university_id"] = 'sometimes|required';
            $educationalAttainmentRules["$prefix.year_graduated"] = 'sometimes|required|numeric|digits:4|min:1900|max:2100';
            $educationalAttainmentRules["$prefix.honor"] = 'sometimes|required';
        }

        foreach ($this->professional_examination as $key => $value) {
            if ($key === 0) {
                continue;
            }
            $prefix = "professional_examination.$key";

            $professionalExaminationRules["$prefix.name_of_examination"] = 'sometimes|required';
            $professionalExaminationRules["$prefix.date_taken"] = 'sometimes|required|date';
            $professionalExaminationRules["$prefix.rating"] = 'sometimes|required';
        }

        $mergedValidationRules = array_merge($educationalAttainmentRules, $professionalExaminationRules);

        if (empty($mergedValidationRules)) {
            $rules["educational_attainment.0.degree_name"] = 'sometimes|required';
            $rules["educational_attainment.0.university_name"] = 'sometimes|required';
            $rules["educational_attainment.0.year_graduated"] = 'sometimes|required|numeric|digits:4|min:1900|max:2100';
            $rules["educational_attainment.0.honor"] = 'sometimes|required';
            $rules["professional_examination.0.name_of_examination"] = 'sometimes|required';
            $rules["professional_examination.0.date_taken"] = 'sometimes|required|date';
            $rules["professional_examination.0.rating"] = 'sometimes|required';
            $rules["type"] = 'sometimes|required';

            return $rules;
        }

        if (empty($educationalAttainmentRules)) {
            $rules["educational_attainment.0.degree_name"] = 'sometimes|required';
            $rules["educational_attainment.0.university_name"] = 'sometimes|required';
            $rules["educational_attainment.0.year_graduated"] = 'sometimes|required|numeric|digits:4|min:1900|max:2100';
            $rules["educational_attainment.0.honor"] = 'sometimes|required';
        }

        if (empty($professionalExaminationRules)) {
            $rules["professional_examination.0.name_of_examination"] = 'sometimes|required';
            $rules["professional_examination.0.date_taken"] = 'sometimes|required|date';
            $rules["professional_examination.0.rating"] = 'sometimes|required';
        }

        $rules = array_merge($mergedValidationRules, $rules);

        return $rules;
    }

    public function addEducationAttainmentRow()
    {
        try {
            $this->validate([
                'educational_attainment.*.degree_name' => 'required',
                'educational_attainment.*.university_name' => 'required',
                'educational_attainment.*.year_graduated' => 'required|numeric|digits:4|min:1900|max:2100',
                'educational_attainment.*.honor' => 'required',
            ]);
            $this->dispatch(
                'educational-attainment-error',
                []
            );
            $this->educational_attainment[] = [
                'degree_name' => $this->educational_attainment[0]['degree_name'],
                'university_name' =>  $this->educational_attainment[0]['university_name'],
                'year_graduated' =>  $this->educational_attainment[0]['year_graduated'],
                'university_name' =>  $this->educational_attainment[0]['university_name'],
                'honor' => $this->educational_attainment[0]['honor'],
            ];
            $this->educational_attainment[0] = ['degree_name' => '', 'university_name' => '', 'year_graduated' => '', 'university_name' => '', 'honor' => ''];
        } catch (ValidationException $e) {
            // dispatch an event to add educational attainment error
            $this->dispatch(
                'educational-attainment-error',
                $e->validator->errors()
            );
        }
    }

    public function addProfessionalExaminationRow()
    {

        try {
            $this->validate([
                'professional_examination.*.name_of_examination' => 'required',
                'professional_examination.*.date_taken' => 'required|date',
                'professional_examination.*.rating' => 'required'
            ]);
            $this->dispatch(
                'professional-examination-error',
                []
            );

            $this->professional_examination[] = [
                'name_of_examination' => $this->professional_examination[0]['name_of_examination'],
                'date_taken' =>  $this->professional_examination[0]['date_taken'],
                'rating' =>  $this->professional_examination[0]['rating'],
            ];
            $this->professional_examination[0] = ['name_of_examination' => '', 'date_taken' => '', 'rating' => '',];
        } catch (ValidationException $e) {
            // dispatch an event to add professional examination error
            $this->dispatch(
                'professional-examination-error',
                $e->validator->errors()
            );
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
            $this->dispatch('validated-education-background', educational_background: $this->except('reason_options'));
            // dispatch an event to send the validated educational background
            $this->dispatch('educational-background-error', [
                'educational_background_errors' => []
            ]);
        } catch (ValidationException $e) {
            // dispatch an event to add educational background error
            $this->dispatch('educational-background-error', [
                'educational_background_tab' => 'tracer-components.educational-background',
                'educational_background_errors' => $e->validator->errors()
            ]);
        } finally {
            $this->skipRender();
        }
    }

    public function render()
    {
        return view('livewire.forms.educational-background', [
            'universities' => University::all(),
            'degree_levels' => Degree::all()
        ]);
    }
}
