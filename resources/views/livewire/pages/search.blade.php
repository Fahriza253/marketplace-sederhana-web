<div class="pt-24 min-h-screen">
    <section class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-display font-semibold text-ink">Hasil pencarian</h1>
                @if ($keyword)
                    <p class="text-slate-600 text-sm mt-1">
                        Menampilkan hasil untuk “<span class="text-primary font-medium">{{ $keyword }}</span>”
                    </p>
                @endif
            </div>
            <div wire:loading class="text-sm text-primary inline-flex items-center gap-2">
                <i class="fa-solid fa-spinner fa-spin"></i>
                Memuat…
            </div>
        </div>

        <form wire:submit.prevent="$refresh"
            class="bg-white rounded-xl border border-slate-200 p-4 mb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="text-xs font-medium text-slate-500">Kata kunci</label>
                <input type="text" wire:model.live.debounce.400ms="keyword" placeholder="Nama / deskripsi"
                    class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="text-xs font-medium text-slate-500">Brand</label>
                <input type="text" wire:model.live.debounce.400ms="brand" placeholder="Toyota, Honda…"
                    class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="text-xs font-medium text-slate-500">Kondisi</label>
                <select wire:model.live="condition"
                    class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                    <option value="">Semua</option>
                    <option value="new">Baru</option>
                    <option value="used">Bekas</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-medium text-slate-500">Harga min</label>
                <input type="number" wire:model.live.debounce.400ms="min_price" placeholder="0"
                    class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="text-xs font-medium text-slate-500">Harga max</label>
                <input type="number" wire:model.live.debounce.400ms="max_price" placeholder="—"
                    class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div class="sm:col-span-2 lg:col-span-5">
                <button type="button" wire:click="clearFilters"
                    class="text-sm text-primary hover:underline inline-flex items-center gap-1">
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset filter
                </button>
            </div>
        </form>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse ($products as $product)
                    <a href="{{ route('products.show', $product) }}" wire:key="search-product-{{ $product->id }}"
                        class="bg-white rounded-lg border border-slate-100 shadow-sm hover:shadow-md transition group block">
                        <div class="overflow-hidden rounded-t-lg bg-slate-100">
                            <img src="{{ $product->primaryImage
                ? asset('storage/' . $product->primaryImage->image_url)
                : asset('img/placeholder-car.svg') }}" alt="{{ $product->name }}"
                                class="w-full h-36 object-cover group-hover:scale-105 transition duration-300" loading="lazy">
                        </div>
                        <div class="p-3 text-sm space-y-1">
                            <p class="text-primary font-semibold">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <p class="font-medium truncate text-ink">{{ $product->name }}</p>
                            <p class="text-slate-500 text-xs truncate">
                                {{ $product->vehicle?->brand }} {{ $product->vehicle?->model }}
                                · {{ $product->seller->name }}
                            </p>
                        </div>
                    </a>
            @empty
                <div class="col-span-full text-center py-16 px-4">
                    <div class="mx-auto w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <i class="fa-solid fa-magnifying-glass text-primary text-2xl"></i>
                    </div>
                    <h2 class="font-display text-lg font-semibold text-ink">Tidak ada produk ditemukan</h2>
                    <p class="text-slate-600 text-sm mt-2 max-w-md mx-auto">
                        Coba ubah kata kunci atau reset filter. Jelajahi katalog lengkap untuk melihat listing tersedia.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3 justify-center">
                        <button type="button" wire:click="clearFilters"
                            class="px-4 py-2 rounded-lg border border-slate-200 text-sm hover:bg-white">
                            Reset filter
                        </button>
                        <a href="{{ route('home') }}"
                            class="px-4 py-2 rounded-lg bg-primary text-white text-sm hover:bg-primary-light">
                            Lihat katalog
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>
</div>