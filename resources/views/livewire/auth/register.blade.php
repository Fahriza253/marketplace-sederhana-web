<x-layouts.auth>
    <div class="min-h-screen flex items-center justify-center bg-surface px-4 py-10">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

            <div class="text-center mb-6">
                <a href="{{ route('landing') }}" class="font-display text-2xl font-bold text-primary">
                    {{ config('app.name') }}
                </a>
                <h2 class="text-ink text-xl font-semibold mt-3">Daftar Akun</h2>
                <p class="text-slate-600 text-sm">Buat akun untuk mulai menjelajah</p>
            </div>

            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-slate-600 text-sm font-medium block" for="name">Nama</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        placeholder="Nama lengkap" autofocus autocomplete="name"
                        class="w-full placeholder:text-slate-400 text-slate-700 border border-slate-200 rounded-md mt-1 py-2 px-3 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm transition">
                    @error('name')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="text-slate-600 text-sm font-medium block" for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        placeholder="email@example.com" autocomplete="email"
                        class="w-full placeholder:text-slate-400 text-slate-700 border border-slate-200 rounded-md mt-1 py-2 px-3 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm transition">
                    @error('email')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="text-slate-600 text-sm font-medium block" for="phone_number">Nomor WhatsApp</label>
                    <input id="phone_number" name="phone_number" type="tel" value="{{ old('phone_number') }}"
                        placeholder="08xxxxxxxxxx" autocomplete="tel"
                        class="w-full placeholder:text-slate-400 text-slate-700 border border-slate-200 rounded-md mt-1 py-2 px-3 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm transition">
                    @error('phone_number')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                    <p class="text-xs text-slate-500 mt-1">Digunakan jika Anda menjadi penjual</p>
                </div>

                <div>
                    <label class="text-slate-600 text-sm font-medium block" for="password">Kata Sandi</label>
                    <input id="password" name="password" type="password" required placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        class="w-full placeholder:text-slate-400 text-slate-700 border border-slate-200 rounded-md mt-1 py-2 px-3 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm transition">
                    @error('password')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="text-slate-600 text-sm font-medium block" for="password_confirmation">Konfirmasi Kata
                        Sandi</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        placeholder="Ulangi kata sandi" autocomplete="new-password"
                        class="w-full placeholder:text-slate-400 text-slate-700 border border-slate-200 rounded-md mt-1 py-2 px-3 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-sm transition">
                </div>

                <label class="flex items-start gap-2 text-sm text-slate-600">
                    <input type="checkbox" required
                        class="mt-1 rounded border-slate-300 text-primary focus:ring-primary">
                    <span>Saya setuju menggunakan DriveHub sebagai platform listing (transaksi di luar sistem).</span>
                </label>

                <button type="submit"
                    class="w-full bg-accent hover:brightness-95 text-ink font-semibold py-2.5 rounded-lg transition">
                    Daftar
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
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-primary hover:underline">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.auth>