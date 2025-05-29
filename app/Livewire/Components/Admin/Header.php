<?php

namespace App\Livewire\Components\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

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
            'icon' => 'fa-calendar',
            'title' => 'Manage Academic Year',
            'url' => '/academic_years'
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
    public $username;
    public $password;

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $this->redirect('/login', navigate: true);
    }

    public function editProfile()
    {
        $validated = $this->validate([
            'username' => 'required',
            'password' => ['nullable'],
        ]);

        if ($validated['password'] == null) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        User::find(Auth::id())->update($validated);

        $this->dispatch('profile-updated', 'Profile updated successfully.');
    }

    public function mount()
    {
        $this->links = [
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
                'icon' => 'fa-calendar',
                'title' => 'Manage Academic Year',
                'url' => '/academic_years'
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
        $this->username = Auth::user()->username;
    }

    public function render()
    {
        return view('livewire.components.admin.header');
    }
}