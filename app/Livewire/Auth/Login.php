<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public string $email = '';
    public string $password = '';

    public function login()
    {
        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password
        ])) {
            return redirect()->to('/home');
        }

        $this->addError('email', 'Email atau password salah');
    }

    #[Layout('layouts.auth')] 
    public function render()
    {
        return view('livewire.auth.login');
    }
}
