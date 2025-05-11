<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ViewGraduate extends Component
{
    public $sections;
    public $graduate;

    public function render()
    {
        return view('livewire.components.view_graduate');
    }
}