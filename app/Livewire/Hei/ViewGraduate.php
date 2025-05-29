<?php

namespace App\Livewire\Hei;

use App\Models\Graduate;
use Illuminate\Contracts\Encryption\DecryptException;
use Livewire\Component;

class ViewGraduate extends Component
{
    public $graduate;

    public $sections;

    public function mount($encrypt_id)
    {
        try {
            $encrypt_id = decrypt($encrypt_id);
        } catch (DecryptException) {
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
        ])->where('graduate_id', $encrypt_id)->firstOrFail();

        $this->sections = [
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
    }

    public function render()
    {
        return view('livewire.hei.view-graduate');
    }
}
