<?php

namespace App\Livewire\Components\Admin;

use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy(isolate: false)]
class DashboardCard extends Component
{
    public $total;
    public $title;
    public $icon;
    public $color;

    public function mount($total, $title, $icon, $color = 'info-content')
    {
        $this->total = $total;
        $this->title = $title;
        $this->icon = $icon;
        $this->color = $color;
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="card bg-white p-4 shadow-sm" lazy>
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">{{$title}}</h2>
            </div>
            <div>
            
            <span class="loading loading-dots loading-sm"></span>
            <span class="loading loading-dots loading-md"></span>
            <span class="loading loading-dots loading-lg"></span>
            <span class="loading loading-dots loading-xl"></span>
            </div>
        </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.components.admin.dashboard-card');
    }
}
