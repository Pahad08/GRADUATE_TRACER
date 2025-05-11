<?php

namespace App\Livewire\Components\Hei;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public $links = [
        [
            'icon' => 'fa-chart-simple',
            'title' => 'Analytics',
            'url' => '/home'
        ],
        [
            'icon' => 'fa-user-graduate',
            'title' => 'View Graduates',
            'url' => '/view_graduates'
        ],
    ];

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $this->redirect('/login', navigate: true);
    }

    public function render()
    {
        return view('livewire.components.hei.header');
    }
}