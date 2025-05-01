<?php

namespace App\Livewire\Admin\Graduates;

use Livewire\Component;

class EmploymentData extends Component
{
    public $employment_data;
    public $employment_details;
    public $reasons;
    public $graduate_reasons;
    public $job_details;
    public $custom_question_responses;

    public function mount($graduate)
    {
        $this->employment_data = $graduate->employmentStatus ?? null;
        $this->reasons = $graduate->reason ?? null;
        $this->employment_details = $graduate->employmentStatus->employmentDetails ?? null;
        $this->graduate_reasons = $graduate->reason ?? null;
        $this->job_details = $graduate->employmentStatus->employmentDetails->jobDetails ?? null;
        $this->custom_question_responses = $graduate->response->filter(function ($response) {
            return optional($response->customQuestion->questionVisibility)->section_name === 'EMPLOYMENT_DATA';
        });
    }

    public function render()
    {
        return view('livewire.admin.graduates.employment-data');
    }
}
