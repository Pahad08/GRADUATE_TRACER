<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Header extends Component
{

    public $childComponents;

    public function mount($childComponents)
    {
        $this->childComponents = $childComponents;
    }

    public function render()
    {
        return view('livewire.components.header');
    }
}