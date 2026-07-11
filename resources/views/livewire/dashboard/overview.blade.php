<div class="pt-24 max-w-7xl mx-auto px-4 py-8 space-y-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-display font-semibold text-ink">Dashboard</h1>
            <p class="text-slate-600 text-sm">Ringkasan listing dan lead WhatsApp Anda</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('products.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-accent text-ink font-medium text-sm hover:brightness-95">
                <i class="fa-solid fa-plus"></i>
                Tambah produk
            </a>
            <a href="{{ route('products.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 bg-white text-sm hover:bg-slate-50">
                <i class="fa-solid fa-car"></i>
                Kelola produk
            </a>
            <a href="{{ route('dashboard.finance') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 bg-white text-sm hover:bg-slate-50">
                <i class="fa-solid fa-chart-line"></i>
                Finance
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-xs text-slate-500">Total listing</p>
            <p class="text-2xl font-semibold text-ink mt-1">{{ $total }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-xs text-slate-500">Tersedia</p>
            <p class="text-2xl font-semibold text-green-700 mt-1">{{ $available }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-xs text-slate-500">Tidak tersedia</p>
            <p class="text-2xl font-semibold text-amber-700 mt-1">{{ $unavailable }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-xs text-slate-500">Terjual</p>
            <p class="text-2xl font-semibold text-slate-700 mt-1">{{ $sold }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-xs text-slate-500">Lead WhatsApp</p>
            <p class="text-2xl font-semibold text-primary mt-1">{{ $leads }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 p-4 md:p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-ink">Produk terbaru</h2>
            <a href="{{ route('products.index') }}" class="text-sm text-primary hover:underline">Lihat semua</a>
        </div>

        @if ($recent->isEmpty())
            <p class="text-sm text-slate-500 py-6 text-center">Belum ada produk. Mulai dengan menambahkan listing.</p>
        @else
            <ul class="divide-y divide-slate-100">
                @foreach ($recent as $product)
                    <li class="py-3 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <img src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_url) : asset('img/placeholder-car.svg') }}"
                                alt="" class="w-12 h-12 rounded object-cover bg-slate-100">
                            <div class="min-w-0">
                                <p class="font-medium truncate">{{ $product->name }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ $product->category->name ?? '-' }} · Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('products.edit', $product) }}"
                            class="text-sm text-primary hover:underline shrink-0">Edit</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>