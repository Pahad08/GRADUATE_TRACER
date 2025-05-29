<?php

namespace App\Livewire\TracerComponents;

use App\Livewire\Forms\EmploymentDataForm;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use App\Models\CustomQuestion;
use App\Models\QuestionVisibility;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class EmploymentData extends Component
{
    public EmploymentDataForm $form;

    //options
    public $occupations = [
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
    public $unemployment_reasons = [
        "Advance or further study",
        "No job opportunity",
        "Family concern and decided not to find a job",
        "Health-related reason(s)",
        "Lack of work experience"
    ];
    public $employment_status = [
        "Regular/Permanent",
        "Contractual",
        "Temporary",
        "Self-employed",
        "Casual"
    ];
    public $industries = [
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
    public $reasons = [
        "Salaries and benefits",
        "Career challenge",
        "Related to special skill",
        "Related to course or program of study",
        "Proximity to residence",
        "Peer influence",
        "Family influence"
    ];
    public $first_job_durations = [
        "Less than a month",
        "1 to 6 months",
        "7 to 11 months",
        "1 year to less than 2 years",
        "2 years to less than 3 years",
        "3 years to less than 4 years"
    ];
    public $first_job_sources = [
        "Response to an advertisement",
        "As walk-in applicant",
        "Recommended by someone",
        "Information from friends",
        "Arranged by school’s job placement officer",
        "Family business",
        "Job Fair or Public Employment Service Office (PESO)"
    ];
    public $first_job_search_durations = [
        "Less than a month" => 'Less than a month',
        "1 to 6 months" => '1 to 6 months',
        "7 to 11 months" => "7 to 11 months",
        "1 year to less than 2 years" => '1 to 2 years',
        "2 years to less than 3 years" => '2 to 3 years',
        "3 years to less than 4 years" => '3 to 4 years',
    ];
    public $job_levels = [
        "Rank/Clerical",
        "Professional/Technical/Supervisory",
        "Managerial/Executive",
        'Self-employed'
    ];
    public $salaryRanges = [
        "Below 5,000.00" => 'Below 5000',
        "₱5,000.00 to less than ₱10,000.00" => '5000-10000',
        "₱10,000.00 to less than ₱15,000.00" => '10000-15000',
        "₱15,000.00 to less than ₱20,000.00" => '15000-20000',
        "₱20,000.00 to less than ₱25,000.00" => '20000-25000',
        "₱25,000.00 and above" => '25000 and above'
    ];
    public $skills = [
        "Communication skills",
        "Human Relations skills",
        "Entrepreneurial skills",
        "Problem-solving skills",
        "Critical Thinking skills"
    ];

    #[On('form-submitted')]
    public function employmentDataValidated()
    {
        try {
            $this->validate();
            $data_to_dispatch = $this->form->is_employed === 'yes' ? $this->form->except(['unemployment_reason'])
                : $this->form->only(['unemployment_reason', 'is_employed', 'suggestions', 'custom_questions']);
            $this->dispatch('validated-employment-data', employment_data: $data_to_dispatch);

            $this->dispatch('employment-data-error', [
                'employment_data_tab' => '',
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

            $this->dispatch('employment-data-error', [
                'employment_data_tab' => 'tracer-components.employment-data',
            ]);

            $this->dispatch('form-error');
        }
    }

    public function addSuggestionInput()
    {
        try {
            $this->form->validateSuggestion();
            $this->form->suggestions[] = $this->form->suggestions[0];
            $this->form->suggestions[0] = '';
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

    public function deleteSuggestionInput($index)
    {
        unset($this->form->suggestions[$index]);
        $this->form->suggestions = array_values($this->form->suggestions);
    }

    public function mount()
    {
        $this->form->suggestions[] = '';
        $questions = CustomQuestion::with(['questionVisibility', 'questionOption'])
            ->whereHas('questionVisibility', function ($query) {
                $query->where('section_name', 'EMPLOYMENT_DATA')->where('is_visible', true);
            })
            ->get();

        $this->form->custom_questions = $questions->mapWithKeys(function ($question) {
            $key = Str::slug($question->label, '_');

            $value = $question->questionOption->isNotEmpty() ? [] : '';

            return [$key => $value];
        })->toArray();
    }

    #[On('graduate-created')]
    public function resetEmploymentData()
    {
        $this->form->reset();
        $this->form->suggestions[] = '';

        $questions = CustomQuestion::with(['questionVisibility', 'questionOption'])
            ->whereHas('questionVisibility', function ($query) {
                $query->where('section_name', 'EMPLOYMENT_DATA')->where('is_visible', true);
            })
            ->get();

        $this->form->custom_questions = $questions->mapWithKeys(function ($question) {
            $key = Str::slug($question->label, '_');

            $value = $question->questionOption->isNotEmpty() ? [] : '';

            return [$key => $value];
        })->toArray();
    }

    #[Computed]
    public function questionVisibility()
    {
        return QuestionVisibility::with('question.questionOption')->where('section_name', 'EMPLOYMENT_DATA')
            ->where('is_visible', true)->orderBy('question_order')->get()->keyBy('question_key');
    }

    public function render()
    {
        return view('livewire.forms.employment-data');
    }
}