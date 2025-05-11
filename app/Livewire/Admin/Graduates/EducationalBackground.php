<?php

namespace App\Livewire\Admin\Graduates;

use Livewire\Component;

class EducationalBackground extends Component
{
    public $educational_backgrounds;
    public $examinations;
    public $graduate_reasons;
    public $custom_question_responses;

    public function mount($graduate)
    {
        $this->educational_backgrounds = $graduate->educationalBackground;
        $this->examinations = $graduate->professionalExamination;
        $this->graduate_reasons = $graduate->reasonForCourse;
        $this->custom_question_responses = $graduate->response->filter(function ($response) {
            return $response->customQuestion->questionVisibility->section_name === 'EDUCATIONAL_BACKGROUND';
        });
    }

    public function render()
    {
        return view('livewire.admin.graduates.educational-background');
    }
}