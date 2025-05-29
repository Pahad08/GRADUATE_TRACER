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

    protected function messages()
    {
        return [
            'is_employed.required' => 'The Employment status is required.',
            'unemployment_reason.checkboxes.required' => 'Please provide a reason for unemployment.',
            'unemployment_reason.input.required' => 'Please provide a reason for unemployment.',
            'present_employment_status.required' => 'The Present Employment Status is required.',
            'occupation.required' => 'The Occupation is required.',
            'company_name.required' => 'The Company Name is required.',
            'industry.required' => 'The Industry is required.',
            'place_of_work.required' => 'The Place of Work is required.',
            'is_first_job.required' => 'This field is required.',
            'job_retention.checkboxes.required' => 'At least one reason for job retention is required.',
            'job_retention.input.required' => 'Please provide a reason for job retention.',
            'related_to_course.required' => 'The Related to Course field is required.',
            'job_acceptance.checkboxes.required' => 'At least one reason for job acceptance is required.',
            'job_acceptance.input.required' => 'Please provide a reason for job acceptance.',
            'job_change.checkboxes.required' => 'At least one reason for job change is required.',
            'job_change.input.required' => 'Please provide a reason for job change.',
            'first_job_duration.required' => 'Select atleast one selection from the options.',
            'job_source.checkboxes.required' => 'At least one job source is required.',
            'job_source.input.required' => 'Please provide a job source.',
            'first_job_search_duration.required' => 'The First Job Search Duration is required.',
            'first_job_level.required' => 'The First Job Level is required.',
            'current_job_level.required' => 'The Current Job Level is required.',
            'first_job_initial_gross.required' => 'The First Job Initial Gross is required.',
            'is_curriculum_relevant_to_job.required' => 'This field is required.',
            'skills.checkboxes.required' => 'At least one skill is required.',
            'skills.input.required' => 'Please provide a skill.',
            'custom_questions.*.required' => 'The :attribute is required.',
        ];
    }

    public function validateSuggestion()
    {
        $this->validate([
            'suggestions.*' => 'required',
        ]);
    }
}
