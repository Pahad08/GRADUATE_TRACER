<?php

namespace App\Livewire\Admin\Graduates;

use Livewire\Component;

class StudiesInformation extends Component
{
    public $graduate;

    public function render()
    {
        return view('livewire.admin.graduates.studies-information');
    }
}
