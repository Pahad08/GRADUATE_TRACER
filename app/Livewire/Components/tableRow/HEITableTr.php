<?php

namespace App\Livewire\Components\tableRow;

use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Reactive;

#[Lazy(isolate: false)]
class HEITableTr extends Component
{
    #[Reactive]
    public $hei;
    public $num;

    public function placeholder(array $params = [])
    {
        return view('livewire.components.loader.table-loader', ['length' => 2]);
    }

    public function render()
    {
        return view('livewire.components.tableRow.hei-table-tr');
    }
}
