<?php

namespace App\Livewire\Admin\Graduates;

use Livewire\Component;

class EducationalBackground extends Component
{
    public $graduate;

    public function render()
    {
        return view('livewire.admin.graduates.educational-background');
    }
}
