<?php

namespace App\Livewire\Components\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public $links = [
        [
            'icon' => 'fa-chart-simple',
            'title' => 'Analytics',
            'url' => '/admin'
        ],
        [
            'icon' => 'fa-user-graduate',
            'title' => 'View Graduates',
            'url' => '/graduates'
        ],
        [
            'icon' => 'fa-clipboard-list',
            'title' => 'Manage Questions',
            'url' => '/questions'
        ],
        [
            'icon' => 'fa-school',
            'title' => 'HEI',
            'url' => '/hei'
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
        return view('livewire.components.admin.header');
    }
}
