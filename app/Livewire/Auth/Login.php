<?php

namespace App\Livewire\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{

    public $username = '';
    public $password = '';

    protected function rules()
    {
        return [
            'username' => ['required'],
            'password' => ['required'],
        ];
    }

    protected function messages()
    {
        return [
            'username.required' => 'Please provide your username.',
            'password.required' => 'Please provide your password.',
        ];
    }

    public function login(Request $request)
    {
        $credentials = $this->validate();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirect('/admin', navigate: true);
        }

        $this->addError('invalid_credentials', 'Invalid email or password.');
        return;
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}