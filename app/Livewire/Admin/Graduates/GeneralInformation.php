<?php

namespace App\Livewire\Admin\Graduates;

use Livewire\Component;

class GeneralInformation extends Component
{
    public $graduate;

    public function render()
    {
        return view('livewire.admin.graduates.general-information');
    }
}
