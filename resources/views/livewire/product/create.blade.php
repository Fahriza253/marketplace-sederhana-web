<div class="bg-white rounded-xl shadow p-6 max-w-7xl mx-auto mt-3 mb-3">

    <h2 class="text-lg font-semibold mb-6 border-b pb-3">
        Unggah Produk Mobil</h2>

    <form wire:submit.prevent="save"
        class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- ================= LEFT SECTION ================= --}}
        <div class="md:col-span-2 space-y-4">

            {{-- NAMA PRODUK --}}
            <div>
                <label class="text-sm font-medium text-gray-700">
                    Nama Produk</label>
                <input type="text"
                    wire:model.defer="name"
                    class="w-full mt-1 border-b outline-none border-gray-300 py-1 px-2 
                        focus:border-gray-400 transition-colors"
                    placeholder="Masukkan nama produk">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- HARGA --}}
            <div>
                <label class="text-sm font-medium text-gray-700">
                    Harga</label>
                <div class="relative mt-1">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">
                        Rp</span>
                    <input type="number"
                        wire:model.defer="price"
                        class="w-full pl-10 mt-1 border-b outline-none border-gray-300 py-1 px-2 
                        focus:border-gray-400 transition-colors"
                        placeholder="0">
                </div>
                @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- STOK --}}
            <div>
                <label class="text-sm font-medium text-gray-700">
                    Stok</label>
                <input type="number"
                    wire:model.defer="stock"
                    class="w-full mt-1 border-b outline-none border-gray-300 py-1 px-2 
                        focus:border-gray-400 transition-colors">
                @error('stock')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- KATEGORI --}}
            <div>
                <label class="text-sm font-medium text-gray-700">
                    Kategori Produk</label>
                <select wire:model="category_id"
                    class="w-full mt-1 border-b outline-none border-gray-300 py-1 px-2 
                        focus:border-gray-400 transition-colors">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- DESKRIPSI --}}
            <div>
                <label class="text-sm font-medium text-gray-700">
                    Deskripsi</label>
                <textarea wire:model.defer="description"
                    rows="4"
                    class="w-full mt-1 border-b outline-none border-gray-300 py-1 px-2 
                        focus:border-gray-400 transition-colors"
                    placeholder="Deskripsi produk"
                ></textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ========== VEHICLE INFORMATION ========== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm font-medium">Brand</label>
                    <input type="text"
                        wire:model.defer="brand"
                        class="w-full mt-1 border-b outline-none border-gray-300 py-1 px-2
                            focus:border-gray-400 transition-colors">
                    @error('brand') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium">Model</label>
                    <input type="text"
                        wire:model.defer="model"
                        class="w-full mt-1 border-b outline-none border-gray-300 py-1 px-2
                            focus:border-gray-400 transition-colors">
                    @error('model') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium">Tahun</label>
                    <input type="number"
                        wire:model.defer="year"
                        class="w-full mt-1 border-b outline-none border-gray-300 py-1 px-2
                            focus:border-gray-400 transition-colors">
                    @error('year') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium">Kapasitas Mesin</label>
                    <input
                        type="text"
                        wire:model.defer="engine_capacity"
                        class="w-full mt-1 border-b outline-none border-gray-300 py-1 px-2
                            focus:border-gray-400 transition-colors">
                    @error('engine_capacity') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>

        {{-- ================= RIGHT SECTION ================= --}}
        <div class="space-y-4 mt-2">

            <label class="text-sm font-medium text-gray-700">
                Gambar Produk</label>

            <input type="file"
                wire:model="newImages"
                multiple
                class="w-full text-sm py-1 px-2 border-b border-gray-500"/>

            <div wire:loading wire:target="newImages" class="text-xs text-gray-500">
                Mengunggah preview...</div>

            @error('images')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
            @error('newImages.*')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror

            {{-- IMAGE PREVIEW --}}
            <div class="flex flex-col gap-3">
                @foreach ($images as $index => $image)
                    <div class="relative flex items-center gap-3 group border rounded-lg p-2">
                        <img
                            src="{{ $image->temporaryUrl() }}"
                            class="w-24 h-24 object-cover rounded-lg
                            {{ $primaryImageIndex === $index
                                ? 'ring-2 ring-blue-500'
                                : 'hover:ring-2 hover:ring-blue-300' }}">
                        <div class="flex flex-col gap-1">
                            <button type="button"
                                wire:click="setPrimaryImage({{ $index }})"
                                class="text-xs px-2 py-1 rounded
                                    {{ $primaryImageIndex === $index ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-blue-100' }}">
                                Jadikan Primary
                            </button>
                            <button type="button"
                                wire:click="removeImage({{ $index }})"
                                class="text-xs px-2 py-1 rounded bg-red-500 text-white hover:bg-red-600">
                                Hapus
                            </button>
                        </div>
                        @if ($primaryImageIndex === $index)
                            <span
                                class="absolute top-1 right-1 text-[10px]
                                bg-blue-600 text-white px-2 py-0.5 rounded">
                                Primary
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
            <button
                type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600
                       transition text-white py-2 rounded-lg font-semibold">
                Simpan Produk
            </button>
        </div>
    </form>
</div>
