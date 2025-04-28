<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;

class EmploymentDataForm extends Form
{
    public $is_employed = '';
    public $unemployment_reason = ['input' => '', 'checkboxes' => []];
    public $present_employment_status = '';
    public $occupation = '';
    public $company_name = '';
    public $industry = '';
    public $place_of_work = '';
    public $is_first_job = '';
    public $job_retention = ['input' => '', 'checkboxes' => []];
    public $related_to_course = '';
    public $job_acceptance = ['input' => '', 'checkboxes' => []];
    public $job_change = ['input' => '', 'checkboxes' => []];
    public $first_job_duration = [];
    public $job_source = ['input' => '', 'checkboxes' => []];
    public $first_job_search_duration = '';
    public $first_job_level = '';
    public $current_job_level = '';
    public $first_job_initial_gross = '';
    public $is_curriculum_relevant_to_job = '';
    public $skills = ['input' => '', 'checkboxes' => []];
    public $suggestions = [];
    public $custom_questions = [];

    //options
    protected $occupations = [
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
    protected $employment_status = [
        "Regular/Permanent",
        "Contractual",
        "Temporary",
        "Self-employed",
        "Casual"
    ];
    protected $industries = [
        "Agriculture, Hunting and Forestry",
        "Fishing",
        "Mining and Quarrying",
        "Manufacturing",
        "Electricity, Gas and Water Supply",
        "Construction",
        "Wholesale and Retail Trade, repair of motor vehicles, motorcycles and personal and household goods",
        "Hotels and Restaurants",
        "Transport Storage and Communication",
        "Financial Intermediation",
        "Real Estate, Renting and Business Activities",
        "Public Administration and Defense; Compulsory Social Security",
        "Education",
        "Health and Social Work",
        "Other Community, Social and Personal Service Activities",
        "Private Households with Employed Persons",
        "Extra-territorial Organizations and Bodies"
    ];

    protected function rules()
    {
        return [
            'is_employed' => [
                'sometimes',
                'required',
                Rule::in(['yes', 'no', 'never'])
            ],
            'unemployment_reason.checkboxes' => [
                'sometimes',
                Rule::requiredIf($this->is_employed !== 'yes' && !empty($this->is_employed) && empty($this->unemployment_reason['input'])),
            ],
            'unemployment_reason.input' => [
                'sometimes',
                Rule::requiredIf($this->is_employed !== 'yes' && !empty($this->is_employed) && empty($this->unemployment_reason['checkboxes'])),
            ],
            'present_employment_status' => [
                'sometimes',
                Rule::requiredIf($this->is_employed === 'yes' && !empty($this->is_employed)),
                Rule::in($this->employment_status)
            ],
            'occupation' => [
                'sometimes',
                Rule::requiredIf($this->is_employed === 'yes' && !empty($this->is_employed)),
                Rule::in($this->occupations)
            ],
            'company_name' => [
                'sometimes',
                Rule::requiredIf($this->is_employed === 'yes' && !empty($this->is_employed)),
            ],
            'industry' => [
                'sometimes',
                Rule::requiredIf($this->is_employed === 'yes' && !empty($this->is_employed)),
                Rule::in($this->industries)
            ],
            'place_of_work' => [
                'sometimes',
                Rule::requiredIf($this->is_employed === 'yes' && !empty($this->is_employed)),
            ],
            'is_first_job' => [
                'sometimes',
                Rule::requiredIf($this->is_employed === 'yes' && !empty($this->is_employed)),
                'boolean'
            ],
            'job_retention.checkboxes' => [
                'sometimes',
                Rule::requiredIf(
                    $this->is_employed === 'yes' && !empty($this->is_employed) && $this->is_first_job == '1'
                        && empty($this->job_retention['input'])
                ),
            ],
            'job_retention.input' => [
                'sometimes',
                Rule::requiredIf(
                    $this->is_employed === 'yes' && !empty($this->is_employed) && $this->is_first_job == '1'
                        && empty($this->job_retention['checkboxes'])
                ),
            ],
            'related_to_course' => [
                'sometimes',
                Rule::requiredIf($this->is_employed == 'yes' && !empty($this->is_employed && $this->is_first_job == '1')),
                'boolean'
            ],
            'job_acceptance.checkboxes' => [
                'sometimes',
                Rule::requiredIf($this->is_employed == 'yes' && !empty($this->is_employed)  && $this->related_to_course == '1' && empty($this->job_acceptance['input'])),
            ],
            'job_acceptance.input' => [
                'sometimes',
                Rule::requiredIf($this->is_employed == 'yes' && !empty($this->is_employed) && $this->related_to_course == '1' && empty($this->job_acceptance['checkboxes'])),
            ],
            'job_change.checkboxes' => [
                'sometimes',
                Rule::requiredIf($this->is_employed === 'yes' && !empty($this->is_employed) && $this->is_first_job == '0'
                    && empty($this->job_change['input'])),
            ],
            'job_change.input' => [
                'sometimes',
                Rule::requiredIf($this->is_employed === 'yes' && !empty($this->is_employed) && $this->is_first_job == '0'
                    && empty($this->job_change['checkboxes'])),
            ],
            'first_job_duration' => [
                'sometimes',
                Rule::requiredIf($this->is_employed === 'yes' && !empty($this->is_employed) && $this->is_first_job == '0'),
            ],
            'job_source.checkboxes' => [
                'sometimes',
                Rule::requiredIf($this->is_employed == 'yes' && !empty($this->is_employed) && empty($this->job_source['input'])),
            ],
            'job_source.input' => [
                'sometimes',
                Rule::requiredIf($this->is_employed == 'yes' && !empty($this->is_employed) && empty($this->job_source['checkboxes'])),
            ],
            'first_job_search_duration' => [
                'sometimes',
                Rule::requiredIf($this->is_employed == 'yes' && !empty($this->is_employed)),
            ],
            'first_job_level' => [
                'sometimes',
                Rule::requiredIf($this->is_employed == 'yes' && !empty($this->is_employed)),
            ],
            'current_job_level' => [
                'sometimes',
                Rule::requiredIf($this->is_employed == 'yes' && !empty($this->is_employed)),
            ],
            'first_job_initial_gross' => [
                'sometimes',
                Rule::requiredIf($this->is_employed == 'yes' && !empty($this->is_employed)),
            ],
            'is_curriculum_relevant_to_job' => [
                'sometimes',
                Rule::requiredIf($this->is_employed == 'yes' && !empty($this->is_employed)),
                'boolean'
            ],
            'skills.checkboxes' => [
                'sometimes',
                Rule::requiredIf(
                    $this->is_employed === 'yes' && !empty($this->is_employed)  &&
                        empty($this->skills['input']) && $this->is_curriculum_relevant_to_job == '1'
                ),
            ],
            'skills.input' => [
                'sometimes',
                Rule::requiredIf($this->is_employed === 'yes' && !empty($this->is_employed)
                    && empty($this->skills['checkboxes']) && $this->is_curriculum_relevant_to_job == '1'),
            ],
            'custom_questions.*' => [
                'sometimes',
                Rule::requiredIf(count($this->custom_questions) > 0),
            ]
        ];
    }

    public function validateSuggestion()
    {
        $this->validate([
            'suggestions.*' => 'required',
        ]);
    }
}