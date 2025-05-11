<?php

namespace App\Livewire\HEi;

use App\Models\Graduate;
use Livewire\Component;

class ViewGraduate extends Component
{
    public $graduate;

    public $sections = [
        'admin.graduates.general-information' => [
            'icon' => 'fa-user',
            'title' => 'General Information',
        ],
        'admin.graduates.educational-background' =>  [
            'icon' => 'fa-user-graduate',
            'title' => 'Educational Background',
        ],
        'admin.graduates.studies-information' => [
            'icon' => 'fa-certificate',
            'title' => 'Training/Advance Studies',
        ],
        'admin.graduates.employment-data' => [
            'icon' => 'fa-user-tie',
            'title' => 'Employment Data',
        ]
    ];

    public function mount($encrypt_id)
    {
        $encrypt_id = decrypt($encrypt_id);

        if (!$encrypt_id) {
            abort(404);
        }
        $this->graduate = Graduate::with([
            'educationalBackground',
            'professionalExamination',
            'reasonForCourse',
            'training',
            'reason',
            'employmentStatus',
            'response.customQuestion.questionVisibility',
            'region',
            'province',
        ])->where('graduate_id', $encrypt_id)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.hei.view-graduate');
    }
}