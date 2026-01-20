<div class="max-w-7xl mx-auto px-4 py-6 space-y-10">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- IMAGE GALLERY --}}
        <div class="space-y-4">
            <div class="border rounded-xl overflow-hidden bg-white shadow">
                <img
                    src="{{ $images[$activeImage] ?? 'https://source.unsplash.com/800x600/?product' }}"
                    class="w-full h-[280px] md:h-[380px] object-cover hover:scale-105 transition duration-300">
            </div>

            <div class="flex gap-3">
                @foreach ($images as $index => $image)
                    <button wire:click="selectImage({{ $index }})"
                        class="border rounded-lg overflow-hidden w-20 h-20
                        {{ $activeImage === $index ? 'ring-2 ring-blue-500' : '' }}">
                        <img src="{{ $image }}" class="w-full h-full object-cover">
                    </button>
                @endforeach
            </div>
        </div>

        {{-- PRODUCT INFO --}}
        <div class="space-y-5">
            <div>
                <h1 class="text-2xl font-semibold">{{ $product->name }}</h1>
                <div class="text-sm text-gray-600 mt-1 flex gap-4">
                    <span>Status:
                        <b class="text-green-600">{{ $product->status }}</b>
                    </span>
                    <span>Kondisi:
                        <b class="text-orange-500">{{ $product->condition }}</b>
                    </span>
                </div>
            </div>

            {{-- META --}}
            @if ($product->vehicle)
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Brand</p>
                    <p class="font-medium">{{ $product->vehicle->brand }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Model</p>
                    <p class="font-medium">{{ $product->vehicle->model }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Tahun</p>
                    <p class="font-medium">{{ $product->vehicle->year }}</p>
                </div>
            </div>
            @endif

            {{-- PRICE --}}
            <div>
                <p class="text-2xl font-bold text-blue-600">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
            </div>

            {{-- CTA --}}
            <a href="https://wa.me/6289507295454" target="__blank">
                <button class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg font-semibold">
                    <i class="fa-brands fa-whatsapp fa-xl"></i>
                    Hubungi Penjual
                </button>
            </a>
        </div>
    </div>

    {{-- TABS --}}
    <div class="bg-white rounded-xl shadow">
        <div class="flex border-b text-sm font-medium">
            <button wire:click="$set('activeTab','description')"
                class="px-6 py-3 {{ $activeTab === 'description' ? 'border-b-2 border-orange-500 text-orange-500' : '' }}">
                DESCRIPTION
            </button>
            <button wire:click="$set('activeTab','info')"
                class="px-6 py-3 {{ $activeTab === 'info' ? 'border-b-2 border-orange-500 text-orange-500' : '' }}">
                ADDITIONAL INFORMATION
            </button>
        </div>

        <div class="p-6 text-sm text-gray-700">
            @if ($activeTab === 'description')
                {{ $product->description }}
            @else
                <p>Kategori: {{ $product->category->name }}</p>
                <p>Penjual: {{ $product->seller->name }}</p>
            @endif
        </div>
    </div>
</div>
