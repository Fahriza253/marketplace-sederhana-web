<header class="fixed top-0 inset-x-0 z-50">
    {{-- TOP NAVIGATION --}}
    <div class="bg-primary text-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center w-full gap-4">
            <div class="flex items-center gap-2 font-bold text-xl shrink-0 md:w-[30%]">
                <a href="{{ route('landing') }}" class="font-bold text-2xl tracking-tight">
                    {{ config('app.name') }}
                </a>
            </div>

            <div class="flex-1 flex justify-center md:w-[40%]">
                <form action="{{ route('search') }}" method="GET"
                    class="w-full max-w-xl hidden md:flex items-center gap-2">
                    <div class="relative w-full">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Cari mobil, brand, atau model…"
                            class="w-full bg-white border border-slate-200 rounded-lg pl-10 pr-4 py-2 text-gray-700 transition duration-300 ease focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 shadow-sm" />
                    </div>
                </form>
            </div>

            <div class="flex items-center justify-end gap-3 shrink-0 md:w-[30%]">
                @guest
                    <a href="{{ route('register') }}" class="px-3 py-2 font-medium hover:underline">Daftar</a>
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 font-medium bg-white text-primary rounded-md text-center hover:bg-slate-50 transition">
                        Masuk
                    </a>
                @endguest

                @auth
                    <div x-data="{ open: false }" class="relative flex items-center gap-3">
                        @if (auth()->user()->hasRole(['admin', 'seller']))
                            <a href="{{ route('products.create') }}" title="Tambah produk"
                                class="bg-white/20 rounded-full w-10 h-10 flex items-center justify-center hover:bg-white/30 transition focus:outline-none"
                                aria-label="Tambah produk">
                                <i class="fa-solid fa-plus text-white"></i>
                            </a>
                        @endif

                        <button type="button" @click="open = !open" @click.outside="open = false"
                            class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition focus:outline-none"
                            aria-label="Menu akun">
                            <span class="font-semibold">
                                {{ auth()->user()->initials() }}
                            </span>
                        </button>

                        <div x-show="open"
                            class="absolute right-0 top-12 w-52 py-1 bg-white rounded-md shadow-lg overflow-hidden text-sm text-gray-700 z-50"
                            x-transition x-cloak>
                            @if (auth()->user()->hasRole(['admin', 'seller']))
                                <a href="{{ route('dashboard') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 transition">
                                    <i class="fa-solid fa-gauge text-primary w-4"></i>
                                    Dashboard
                                </a>
                                <a href="{{ route('products.index') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 transition">
                                    <i class="fa-solid fa-car text-primary w-4"></i>
                                    Produk
                                </a>
                                <a href="{{ route('dashboard.finance') }}"
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 transition">
                                    <i class="fa-solid fa-chart-line text-primary w-4"></i>
                                    Finance
                                </a>
                            @endif

                            <div class="border-t border-slate-200"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 text-left px-4 py-2 text-red-600 hover:bg-red-50 transition">
                                    <i class="fa-solid fa-right-from-bracket w-4"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    @if ($this->isHome)
        <nav class="bg-white text-black border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 py-2 flex gap-6 text-sm items-center justify-center flex-wrap">
                <a href="{{ route('search') }}"
                    class="text-primary font-medium hover:underline inline-flex items-center gap-1">
                    <i class="fa-solid fa-filter"></i>
                    Filter pencarian
                </a>

                @auth
                    @if (auth()->user()->hasRole(['admin', 'seller']))
                        <a href="{{ route('products.create') }}" class="hover:underline inline-flex items-center gap-1">
                            <i class="fa-solid fa-plus"></i>
                            Mulai Menjual
                        </a>
                    @endif
                @endauth

                <a href="{{ route('about') }}" class="hover:underline">Tentang</a>
            </div>
        </nav>
    @elseif (!empty($this->breadcrumbs))
        <nav class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 py-3">
                <ol class="flex items-center text-sm text-gray-600 space-x-2">
                    @foreach ($this->breadcrumbs as $i => $crumb)
                        <li class="flex items-center">
                            @if ($crumb['url'] && $i !== count($this->breadcrumbs) - 1)
                                <a href="{{ $crumb['url'] }}" class="hover:text-primary font-medium">
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
</header>