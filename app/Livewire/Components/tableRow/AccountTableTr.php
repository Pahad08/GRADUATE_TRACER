<?php

namespace App\Livewire\Components\TableRow;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Reactive;

#[Lazy(isolate: false)]
class AccountTableTr extends Component
{
    #[Reactive]
    public $account;
    public $hei_name;
    public $num;

    public function placeholder(array $params = [])
    {
        return view('livewire.components.loader.table-loader', ['length' => 3]);
    }

    public function render()
    {
        return view('livewire.components.tableRow.account-table-tr');
    }
}
