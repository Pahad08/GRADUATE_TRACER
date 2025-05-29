<?php

namespace App\Livewire\Components\Admin;

use Livewire\Component;

class Chart extends Component
{
    public $title;
    public $id;
    public $data_to_fetch;
    public $options;

    public function mount($id, $title, $options, $data_to_fetch = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->data_to_fetch = $data_to_fetch;
        $this->options = $options;
    }

    public function render()
    {
        return view('livewire.components.admin.chart');
    }
}
