<div class="pt-24"> {{-- offset header fixed --}}
    <section class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-lg font-semibold mb-6">
            Hasil pencarian
            @if ($keyword)
                untuk "<span class="text-blue-600">{{ $keyword }}</span>"
            @endif
        </h1>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            @forelse ($products as $product)
                <a href="{{ route('products.show', $product) }}"
                   wire:key="search-product-{{ $product->id }}"
                   class="bg-white rounded-lg shadow hover:shadow-xl transition group block">

                    <div class="overflow-hidden rounded-t-lg bg-gray-100">
                        <img
                            src="{{ $product->primaryImage
                                ? asset('storage/' . $product->primaryImage->image_url)
                                : asset('img/placeholder-car.png') }}"
                            alt="{{ $product->name }}"
                            class="w-full h-36 object-cover group-hover:scale-105 transition"
                            loading="lazy"
                        >
                    </div>

                    <div class="p-3 text-sm space-y-1">
                        <p class="text-blue-600 font-semibold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p class="font-medium truncate">
                            {{ $product->name }}
                        </p>
                        <p class="text-gray-500 text-xs">
                            {{ $product->seller->name }}
                        </p>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-center text-gray-500">
                    Produk tidak ditemukan
                </p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>
</div>
