<header class="fixed top-0 inset-x-0 z-50">
    {{-- TOP NAVIGATION --}}
    <div class="bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center w-full">
            <div class="flex items-center gap-2 font-bold text-xl shrink-0" style="width:30%"> {{-- Brand Identity --}}
                <a href="{{ route('home') }}" class="font-bold text-2xl">DRIVEHUB</a>
            </div>

            <div class="flex justify-center" style="width:40%">
                <form action="{{ route('search') }}"
                    method="GET"
                    class="w-full max-w-xl hidden md:block">
                    <input type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Pencarian produk"
                        class="w-full bg-white border border-slate-200 rounded-lg px-4 py-2 text-gray-500 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"/>
                </form>
            </div>

            <div class="flex items-center justify-end gap-4 shrink-0" style="width:30%">
                @guest
                    <a href="{{ route('register') }}" class="px-4 py-2 font-medium">Register</a>
                    <a href="{{ route('login') }}" class="px-4 py-2 font-light bg-white text-primary w-24 rounded-sm text-center">Login</a>
                @endguest

                @auth
                <div x-data="{ open: false }" class="relative">
                    <button
                        @click="open = !open"
                        @click.outside="open = false"
                        class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition focus:outline-none">
                        <span class="font-semibold">
                            {{ auth()->user()->initials() }}
                        </span>
                    </button>

                    {{-- DROPDOWN --}}
                    <div x-show="open"
                        class="absolute right-0 mt-2 w-48 py-1 bg-white rounded-md shadow-lg overflow-hidden text-sm text-gray-700
                        outline -outline-offset-1 outline-white/10 z-50"
                        x-transition
                        x-cloak>
                        {{-- Product: Only Admin & Seller --}}
                        @if (auth()->user()->hasRole(['admin', 'seller']))
                            <a href="{{ route('products.index') }}"
                                class="block px-4 py-2 hover:bg-gray-100 focus:bg-white/5 focus:outline-hidden transition">
                                Product
                            </a>
                        @endif

                        {{-- Setting: All Authenticated User --}}
                        <a href="#toSetting"
                            class="block px-4 py-2 hover:bg-gray-100 focus:bg-white/5 focus:outline-hidden transition">
                            Setting
                        </a>

                        <div class="border-t border-slate-300"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>

    {{-- Home Section Only --}}
    @if ($this->isHome)
    <nav class="bg-white text-black border-b border-gray-300">
        <div class="max-w-7xl mx-auto px-4 py-2 flex gap-6 text-sm items-center justify-center">
            <button class="bg-white text-blue-700 px-4 py-1 rounded-md font-medium">
                Kategori
            </button>

            @auth
                @if (auth()->user()->hasRole(['admin', 'seller']))
                    <a href="{{ route('products.create') }}" class="hover:underline">
                        Mulai Menjual
                    </a>
                @endif
            @endauth

            <a href="#" class="hover:underline">Customer Service</a>
            <a href="#" class="hover:underline">Bantuan</a>
        </div>
    </nav>
    @else
        @if (!empty($this->breadcrumbs))
            <nav class="bg-white border-b">
                <div class="max-w-7xl mx-auto px-4 py-3">
                    <ol class="flex items-center text-sm text-gray-600 space-x-2">
                        @foreach ($this->breadcrumbs as $i => $crumb)
                            <li class="flex items-center">
                                @if ($crumb['url'] && $i !== count($this->breadcrumbs) - 1)
                                    <a href="{{ $crumb['url'] }}" class="hover:text-blue-600 font-medium">
                                        {{ $crumb['label'] }}
                                    </a>
                                    <span class="mx-2 text-gray-400">/</span>
                                @else
                                    <span class="text-gray-900 font-semibold">
                                        {{ $crumb['label'] }}
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            </nav>
        @endif
    @endif
</header>
