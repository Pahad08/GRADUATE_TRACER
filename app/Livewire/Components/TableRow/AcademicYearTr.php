<?php

namespace App\Livewire\Components\TableRow;

use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Reactive;

#[Lazy(isolate: false)]
class AcademicYearTr extends Component
{
    #[Reactive]
    public $academic_year_id;
    #[Reactive]
    public $start_year;
    #[Reactive]
    public $end_year;

    public function placeholder(array $params = [])
    {
        return view('livewire.components.loader.table-loader', ['length' => 3]);
    }

    public function render()
    {
        return view('livewire.components.tablerow.academic-year-tr');
    }
}