<?php

namespace App\Livewire\Admin\Graduates;

use Livewire\Component;

class GeneralInformation extends Component
{
    public $graduate;
    public $custom_question_responses;

    public function mount($graduate)
    {
        $this->graduate = $graduate;
        $this->custom_question_responses = $graduate->response->filter(function ($response) {
            return optional($response->customQuestion->responsesWithTrashed)->section_name === 'GENERAL_INFORMATION';
        });
    }

    public function render()
    {
        return view('livewire.admin.graduates.general-information');
    }
}