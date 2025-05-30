<?php

namespace App\Livewire\Components\TableRow;

use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Reactive;

#[Lazy(isolate: false)]
class AccountTableTr extends Component
{
    #[Reactive]
    public $user_id;
    #[Reactive]
    public $username;
    #[Reactive]
    public $inst_name;

    public function placeholder(array $params = [])
    {
        return view('livewire.components.loader.table-loader', ['length' => 3]);
    }

    public function render()
    {
        return view('livewire.components.tablerow.account-table-tr');
    }
}