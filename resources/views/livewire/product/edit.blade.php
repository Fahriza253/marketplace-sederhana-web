<div class="bg-white rounded-xl shadow p-6 max-w-7xl mx-auto mt-3 mb-3">

    <h2 class="text-lg font-semibold mb-6 border-b pb-3">
        Edit Produk
    </h2>

    <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- LEFT : MAIN FORM --}}
        <div class="md:col-span-2 space-y-5">

            {{-- Nama Produk --}}
            <div>
                <label class="block text-sm font-medium mb-1">Nama Produk</label>
                <input type="text" wire:model.defer="name" class="w-full py-1 px-2 border-gray-300 border-b outline-none
                        focus:border-gray-400 transition-colors">
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Harga & Stok --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Harga</label>
                    <input type="number" wire:model.defer="price" class="w-full py-1 px-2 border-gray-300 border-b outline-none
                        focus:border-gray-400 transition-colors">
                    @error('price') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Stok</label>
                    <input type="number" wire:model.defer="stock" class="w-full py-1 px-2 border-gray-300 border-b outline-none
                        focus:border-gray-400 transition-colors">
                    @error('stock') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select wire:model="status" class="w-full py-1 px-2 border-gray-300 border-b outline-none
                        focus:border-gray-400 transition-colors">
                    <option value="available">Tersedia</option>
                    <option value="unavailable">Tidak tersedia</option>
                    <option value="sold">Terjual</option>
                </select>
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select wire:model="category_id" class="w-full py-1 px-2 border-gray-300 border-b outline-none
                        focus:border-gray-400 transition-colors">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea wire:model.defer="description" rows="4" class="w-full py-1 px-2 border-gray-300 border-b outline-none
                        focus:border-gray-400 transition-colors"></textarea>
            </div>

            {{-- VEHICLE INFO --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium mb-1">Brand</label>
                    <input type="text" wire:model.defer="brand" class="w-full py-1 px-2 border-gray-300 border-b outline-none
                        focus:border-gray-400 transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Model</label>
                    <input type="text" wire:model.defer="model" class="w-full py-1 px-2 border-gray-300 border-b outline-none
                        focus:border-gray-400 transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Tahun</label>
                    <input type="number" wire:model.defer="year" class="w-full py-1 px-2 border-gray-300 border-b outline-none
                        focus:border-gray-400 transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Kapasitas Mesin</label>
                    <input type="text" wire:model.defer="engine_capacity" class="w-full py-1 px-2 border-gray-300 border-b outline-none
                        focus:border-gray-400 transition-colors">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Plat Nomor (opsional)</label>
                    <input type="text" wire:model.defer="license_plate" class="w-full py-1 px-2 border-gray-300 border-b outline-none
                        focus:border-gray-400 transition-colors">
                </div>

            </div>
        </div>

        {{-- RIGHT : IMAGES --}}
        <div class="space-y-5">

            {{-- Images Preview (Old + New) --}}
            <div>
                <p class="text-sm font-medium mb-2">Gambar Produk</p>
                <div class="flex flex-col gap-3">
                    {{-- Gambar lama --}}
                    @foreach ($product->images as $image)
                                    <div class="relative flex items-center gap-3 group border rounded-lg p-2">
                                        <img src="{{ asset('storage/' . $image->image_url) }}" class="w-24 h-24 object-cover rounded-lg
                                                 {{ $primary && $primary['type'] === 'old' && $primary['value'] === $image->id
                        ? 'ring-2 ring-orange-500'
                        : 'hover:ring-2 hover:ring-blue-300' }}">
                                        <div class="flex flex-col gap-1">
                                            <button type="button" wire:click="setPrimaryOld({{ $image->id }})" class="text-xs px-2 py-1 rounded
                                                        {{ $primary && $primary['type'] === 'old' && $primary['value'] === $image->id
                        ? 'bg-blue-600 text-white'
                        : 'bg-gray-200 hover:bg-blue-100' }}">
                                                Jadikan Primary
                                            </button>
                                            <button type="button" wire:click="removeImage({{ $image->id }})"
                                                class="text-xs px-2 py-1 rounded bg-red-500 text-white hover:bg-red-600">
                                                Hapus
                                            </button>
                                        </div>
                                        @if ($primary && $primary['type'] === 'old' && $primary['value'] === $image->id)
                                            <span class="absolute top-1 right-1 text-[10px]
                                                        bg-blue-600 text-white px-2 py-0.5 rounded">
                                                Primary
                                            </span>
                                        @endif
                                    </div>
                    @endforeach
                    {{-- Gambar baru --}}
                    @foreach ($newImages as $index => $image)
                                    <div class="relative flex items-center gap-3 group border rounded-lg p-2">
                                        <img src="{{ $image->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-lg
                                                 {{ $primary && $primary['type'] === 'new' && $primary['value'] === $index
                        ? 'ring-2 ring-orange-500'
                        : 'hover:ring-2 hover:ring-blue-300' }}">
                                        <div class="flex flex-col gap-1">
                                            <button type="button" wire:click="setPrimaryNew({{ $index }})" class="text-xs px-2 py-1 rounded
                                                        {{ $primary && $primary['type'] === 'new' && $primary['value'] === $index
                        ? 'bg-blue-600 text-white'
                        : 'bg-gray-200 hover:bg-blue-100' }}">
                                                Jadikan Primary
                                            </button>
                                            <button type="button" wire:click="removeNewImage({{ $index }})"
                                                class="text-xs px-2 py-1 rounded bg-red-500 text-white hover:bg-red-600">
                                                Hapus
                                            </button>
                                        </div>
                                        @if ($primary && $primary['type'] === 'new' && $primary['value'] === $index)
                                            <span class="absolute top-1 right-1 text-[10px]
                                                        bg-blue-600 text-white px-2 py-0.5 rounded">
                                                Primary
                                            </span>
                                        @endif
                                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Klik "Jadikan Primary" untuk memilih thumbnail utama
                </p>
            </div>

            {{-- Upload New Images --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Tambah Gambar Baru</label>
                <input type="file" multiple wire:model="newImages" class="w-full py-1 px-2 border-gray-300 border-b outline-none
                        focus:border-gray-400 transition-colors text-sm">
                @error('newImages.*')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600
                           text-white py-2 rounded-lg font-semibold transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>