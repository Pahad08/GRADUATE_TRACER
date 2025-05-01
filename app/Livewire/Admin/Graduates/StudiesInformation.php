<?php

namespace App\Livewire\Admin\Graduates;

use Livewire\Component;

class StudiesInformation extends Component
{
    public $graduate;
    public $custom_question_responses;

    public function mount($graduate)
    {
        $this->graduate = $graduate;
        $this->custom_question_responses = $graduate->response->filter(function ($response) {
            return $response->customQuestion->questionVisibility->section_name === 'TRAININGS_STUDIES';
        });
    }

    public function render()
    {
        return view('livewire.admin.graduates.studies-information');
    }
}
