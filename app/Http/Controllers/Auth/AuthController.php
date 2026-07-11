<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('livewire.auth.login');
    }

    public function showRegister()
    {
        return view('livewire.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($validated);

        $consumentRole = Role::firstOrCreate(['name' => 'consument']);
        $user->roles()->syncWithoutDetaching([$consumentRole->id]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $this->ensureIsNotRateLimited($request);

        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request));

            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        throw ValidationException::withMessages([
            'email' => 'Terlalu banyak percobaan login. Coba lagi nanti.',
        ]);
    }

    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')).'|'.$request->ip();
    }
}
