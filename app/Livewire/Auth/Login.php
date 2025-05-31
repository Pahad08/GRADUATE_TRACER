<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
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

        //create a new admin user if no users exist
        if (User::count() === 0) {
            $new_admin = User::create([
                'username' => $this->username,
                'password' => Hash::make($this->password),
            ]);

            $new_admin->is_admin = true;
            $new_admin->save();
            Auth::login($new_admin);
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            return $this->redirect('/admin', navigate: true);
        }

        if (!Auth::attempt($credentials)) {
            RateLimiter::increment($throttleKey);
            return $this->addError('invalid_credentials', 'Invalid username or password.');
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        if (!Auth::user()->is_admin) {
            return $this->redirect('/home', navigate: true);
        }

        return $this->redirect('/admin', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}