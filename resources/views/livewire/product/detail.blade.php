<div class="max-w-7xl mx-auto px-4 py-6 space-y-10">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- IMAGE GALLERY --}}
        <div class="space-y-4">
            <div class="border rounded-xl overflow-hidden bg-white shadow">
                <img src="{{ $images[$activeImage] ?? asset('img/placeholder-car.svg') }}" alt="{{ $product->name }}"
                    class="w-full h-[280px] md:h-[380px] object-cover hover:scale-105 transition duration-300">
            </div>

            <div class="flex gap-3 flex-wrap">
                @foreach ($images as $index => $image)
                    <button type="button" wire:click="selectImage({{ $index }})" class="border rounded-lg overflow-hidden w-20 h-20
                            {{ $activeImage === $index ? 'ring-2 ring-primary' : '' }}">
                        <img src="{{ $image }}" alt="" class="w-full h-full object-cover">
                    </button>
                @endforeach
            </div>
        </div>

        {{-- PRODUCT INFO --}}
        <div class="space-y-5">
            <div>
                <h1 class="text-2xl font-semibold">{{ $product->name }}</h1>
                <div class="text-sm text-gray-600 mt-1 flex gap-4 flex-wrap">
                    <span>Status:
                        <b @class([
                            'text-green-600' => $product->status === 'available',
                            'text-amber-600' => $product->status === 'unavailable',
                            'text-slate-600' => $product->status === 'sold',
                        ])>{{ $product->status }}</b>
                    </span>
                    <span>Kondisi:
                        <b class="text-accent">{{ $product->condition }}</b>
                    </span>
                </div>
            </div>

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

            <div>
                <p class="text-2xl font-bold text-primary">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
            </div>

            @error('contact')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <button type="button" wire:click="contactSeller" wire:loading.attr="disabled" wire:target="contactSeller"
                @disabled(!$this->hasSellerPhone) @class([
                    'w-full py-3 rounded-lg font-semibold inline-flex items-center justify-center gap-2 transition',
                    'bg-green-600 hover:bg-green-700 text-white' => $this->hasSellerPhone,
                    'bg-slate-300 text-slate-500 cursor-not-allowed' => !$this->hasSellerPhone,
                ])>
                <span wire:loading.remove wire:target="contactSeller" class="inline-flex items-center gap-2">
                    <i class="fa-brands fa-whatsapp fa-xl"></i>
                    Hubungi Penjual
                </span>
                <span wire:loading wire:target="contactSeller" class="inline-flex items-center gap-2">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    Membuka WhatsApp…
                </span>
            </button>

            @unless ($this->hasSellerPhone)
                <p class="text-xs text-amber-700">Penjual belum mengisi nomor WhatsApp.</p>
            @else
                <p class="text-xs text-slate-500">
                    Klik untuk membuka chat WhatsApp penjual. Minat Anda akan dicatat di dashboard Finance.
                </p>
            @endunless
        </div>
    </div>

    <div class="bg-white rounded-xl shadow">
        <div class="flex border-b text-sm font-medium">
            <button type="button" wire:click="$set('activeTab','description')"
                class="px-6 py-3 {{ $activeTab === 'description' ? 'border-b-2 border-accent text-accent' : '' }}">
                DESCRIPTION
            </button>
            <button type="button" wire:click="$set('activeTab','info')"
                class="px-6 py-3 {{ $activeTab === 'info' ? 'border-b-2 border-accent text-accent' : '' }}">
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