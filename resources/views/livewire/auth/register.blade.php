<x-layouts.auth>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 transition hover:shadow-2xl">

            {{-- Header --}}
            <div class="text-center mb-6">
                <h2 class="text-gray-800 text-2xl font-bold">Daftar Akun</h2>
                <p class="text-gray-600 text-sm">Buat akun baru untuk melanjutkan</p>
            </div>

            <x-auth-session-status class="text-center" :status="session('status')"/>

            @if (session()->has('success'))
                <div class="text-green-600 text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div> {{-- F U L L  N A M E --}}
                    <label class="text-gray-600 text-sm font-medium block">Nama</label>
                    <input name="name" type="text" required placeholder="Nama Lengkap" autofocus autocomplete="name" 
                    class="w-full bg-transparent  placeholder:text-slate-400 text-slate-700
                        border border-slate-200 rounded-md
                        mt-1 py-2 px-3 
                        focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow
                        transition duration-300 ease">
                    @error('name')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div> {{-- ALAMAT EMAIL --}}
                    <label class="text-gray-600 text-sm font-medium block">Email</label>
                    <input name="email" type="email" required placeholder="email@example.com" 
                        class="w-full bg-transparent  placeholder:text-slate-400 text-slate-700
                        border border-slate-200 rounded-md
                        mt-1 py-2 px-3 
                        focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow
                        transition duration-300 ease">
                    @error('email')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div> {{-- PASSWORD --}}
                    <label class="text-gray-600 text-sm font-medium block">Buat Kata Sandi</label>
                    <input name="password" type="password" required placeholder="Buat kata sandi baru" 
                    class="w-full bg-transparent  placeholder:text-slate-400 text-slate-700
                        border border-slate-200 rounded-md
                        mt-1 py-2 px-3 
                        focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow
                        transition duration-300 ease">
                    @error('password')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div> {{-- KONFIRMASI PASSWORD --}}
                    <label class="text-gray-600 text-sm font-medium block">Konfirmasi Kata Sandi</label>
                    <input name="password_confirmation" type="password" required placeholder="Konfirmasi kata sandi" 
                        class="w-full bg-transparent  placeholder:text-slate-400 text-slate-700
                        border border-slate-200 rounded-md
                        mt-1 py-2 px-3 
                        focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow
                        transition duration-300 ease">
                    @error('password')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>            

                <div class="flex items-start gap-2 text-sm mt-3">
                    <input type="checkbox" required
                        class="mt-1 text-orange-600 border-gray-300 rounded focus:ring-orange-400"> 
                    <p
                        class="text-gray-600">
                        Saya setuju dengan <a href="#" class="text-blue-500 hover:underline">Terms & Conditions</a> dan <a class="text-blue-500 hover:underline" href="#">Privacy Policy</a>
                    </p>
                </div>

                <button type="submit" variant="primary"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition duration-200 mt-3">
                    DAFTAR
                </button>
            </form>

            <div class="flex items-center my-6">
                <hr class="flex-grow border-gray-300">
                <span class="mx-2 text-xs text-gray-600"> Atau </span>
                <hr class="flex-grow border-gray-300">
            </div>

            <div class="space-y-3">
                <button
                    class="w-full flex items-center justify-center gap-2 border rounded-lg py-2 hover:bg-gray-100 transition">
                    {{-- TODO: Tambahkan icon --}}
                    <span class="text-sm font-medium"><a href="{{ route('home') }}">Lanjutkan tanpa akun</a></span>
                </button>
                <span class="text-sm font-medium">{{ ('Sudah memiliki akun?') }}</span>
                <a href="{{ route('login') }}" class="text-sm font-medium text-blue-500"
                    wire:navigate>{{ ('Masuk') }}</a>
            </div>

        </div>
    </div>
</x-layouts.auth>
