<div>
    {{-- ADS SECTION --}}
    <section class="max-w-7xl mx-auto px-4 py-6">
        <div class="grid md:grid-cols-3 gap-4">
                <div class="overflow-hidden rounded-xl shadow-md hover:shadow-lg transition">
                    <img src="{{ asset('img/ads-banner-1.png') }}"
                        class="w-full h-60 hover:scale-101 transition duration-300"
                        alt="Banner">
                </div>
                <div class="overflow-hidden rounded-xl shadow-md hover:shadow-lg transition">
                    <img src="{{ asset('img/ads-banner-3-low.png') }}"
                        class="w-full h-60 hover:scale-101 transition duration-300"
                        alt="Banner">
                </div>
                <div class="overflow-hidden rounded-xl shadow-md hover:shadow-lg transition">
                    <img src="{{ asset('img/ads-banner-2.png') }}"
                        class="w-full h-60 hover:scale-101 transition duration-300"
                        alt="Banner">
                </div>
        </div>
    </section>

    {{-- LIST PRODUCT --}}
    <section class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Rekomendasi</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            @forelse ($products as $product)
                <a href="{{ route('products.show', $product) }}"
                    wire:key="product-{{ $product->id }}"
                    class="bg-white rounded-lg shadow hover:shadow-xl transition group block focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <div class="overflow-hidden rounded-t-lg bg-gray-100">
                        <img src="{{ $product->primaryImage
                                ? asset('storage/' . $product->primaryImage->image_url)
                                : asset('img/placeholder-car.png') }}"
                            alt="{{ $product->name }}"
                            class="w-full h-36 object-cover group-hover:scale-105 transition duration-300"
                            loading="lazy">
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
                <p class="text-gray-500 col-span-full text-center">
                    Produk belum tersedia
                </p>
            @endforelse
        </div>
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>
</div>
