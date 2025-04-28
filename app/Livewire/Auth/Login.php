<?php

namespace App\Livewire\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
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
        $throttleKey = strtolower($this->username) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return $this->addError('too_many_attempts',  'You may try again in ' . $seconds . ' seconds.');
        }

        $credentials = $this->validate();

        if (!Auth::attempt($credentials)) {
            RateLimiter::increment($throttleKey);
            return $this->addError('invalid_credentials', 'Invalid email or password.');
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();
        return $this->redirectIntended('/admin', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
