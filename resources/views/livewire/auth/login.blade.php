<x-layouts.auth>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 transition hover:shadow-2xl">

            <div class="text-center mb-6">
                <h2 class="text-gray-800 text-2xl font-bold">Masuk Akun</h2>
                <p class="text-gray-600 text-sm">Masuk untuk melanjutkan</p>
            </div>

            <x-auth-session-status class="text-center" :status="session('status')"/>
            
            @if (session()->has('success'))
                <div class="text-green-600 text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form {{-- wire:submit.prevent='login' --}}
                method="POST" action="{{ route('login') }}">
                @csrf

                <div> {{-- E M A I L --}}
                    <label class="text-gray-600 text-sm font-medium block">Email</label>
                    <input type="email" name="email" {{-- wire:model.defer='email' --}} required 
                         class="w-full mt-1 py-1 px-3 border rounded-lg focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition">
                    @error('email')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div> {{-- P A S S W O R D --}}
                    <label class="text-gray-600 text-sm font-medium block">Masukan Kata Sandi</label>
                    <input type="password" name="password" {{-- wire:model.defer='password' --}} required  
                        class="w-full mt-1 py-1 px-3 border rounded-lg focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition">
                    @error('password')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>     

                <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition duration-200 mt-3">
                    MASUK
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
                <span class="text-sm font-medium">{{ ('Belum memiliki akun?') }}</span>
                <a href="{{ route('register') }}" class="text-sm font-medium text-blue-500"
                    wire:navigate>{{ ('Buat') }}</a>
            </div>

        </div>
    </div>
</x-layouts.auth>
