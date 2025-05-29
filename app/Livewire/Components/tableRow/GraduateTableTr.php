<?php

namespace App\Livewire\Components\TableRow;

use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy(isolate: false)]
class GraduateTableTr extends Component
{
    public $graduate;
    public $num;

    public function placeholder(array $params = [])
    {
        return view('livewire.components.loader.table-loader', ['length' => 13]);
    }

    public function render()
    {
        return view('livewire.components.tableRow.graduate-table-tr');
    }
}
