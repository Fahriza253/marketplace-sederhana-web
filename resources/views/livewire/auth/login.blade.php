<x-layouts.auth>
    <div class="min-h-screen flex items-center justify-center bg-surface px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

            <div class="text-center mb-6">
                <a href="{{ route('landing') }}" class="font-display text-2xl font-bold text-primary">
                    {{ config('app.name') }}
                </a>
                <h2 class="text-ink text-xl font-semibold mt-3">Masuk Akun</h2>
                <p class="text-slate-600 text-sm">Masuk untuk melanjutkan</p>
            </div>

            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-slate-600 text-sm font-medium block" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full placeholder:text-slate-400 text-slate-700 border border-slate-200 rounded-md mt-1 py-2 px-3 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm transition">
                    @error('email')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="text-slate-600 text-sm font-medium block" for="password">Kata Sandi</label>
                    <input id="password" type="password" name="password" required
                        class="w-full placeholder:text-slate-400 text-slate-700 border border-slate-200 rounded-md mt-1 py-2 px-3 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm transition">
                    @error('password')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1"
                        class="rounded border-slate-300 text-primary focus:ring-primary">
                    Ingat saya
                </label>

                <button type="submit"
                    class="w-full bg-accent hover:brightness-95 text-ink font-semibold py-2.5 rounded-lg transition mt-1">
                    Masuk
                </button>
            </form>

            <div class="flex items-center my-6">
                <hr class="flex-grow border-slate-200">
                <span class="mx-2 text-xs text-slate-500">atau</span>
                <hr class="flex-grow border-slate-200">
            </div>

            <div class="space-y-3 text-center">
                <a href="{{ route('home') }}"
                    class="w-full flex items-center justify-center gap-2 border border-slate-200 rounded-lg py-2 hover:bg-slate-50 transition text-sm font-medium">
                    <i class="fa-solid fa-car"></i>
                    Lanjutkan tanpa akun
                </a>
                <p class="text-sm text-slate-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-primary hover:underline">Daftar</a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.auth>