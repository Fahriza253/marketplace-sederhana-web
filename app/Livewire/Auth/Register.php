<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;

#[Layout('layouts.auth')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }

    public function register(): void
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('success', 'Akun berhasil dibuat. Silakan login.');

        $this->redirect('/login', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
