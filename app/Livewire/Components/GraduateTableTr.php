<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy(isolate: false)]
class GraduateTableTr extends Component
{
    public $graduate;
    public $num;

    public function placeholder(array $params = [])
    {
        return view('livewire.components.loader.table-loader');
    }

    public function render()
    {
        return view('livewire.components.graduate-table-tr');
    }
}
