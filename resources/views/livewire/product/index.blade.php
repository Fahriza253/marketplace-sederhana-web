<div class="bg-white rounded-xl shadow p-4 md:p-6 max-w-7xl mb-2 m-auto">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold">Daftar Produk</h2>
            <p class="text-sm text-gray-500">
                Kelola produk yang telah Anda unggah
            </p>
        </div>

        {{-- FILTER --}}
        <form wire:submit.prevent="applyFilter" class="flex flex-wrap gap-2 items-center">
            <select wire:model.defer="status"
                class="px-3 py-2 text-sm rounded-lg border focus:ring focus:ring-blue-200">
                <option value="">Semua Status</option>
                <option value="available">Tersedia</option>
                <option value="unavailable">Tidak tersedia</option>
                <option value="sold">Terjual</option>
            </select>

            <select wire:model.defer="category"
                class="px-3 py-2 text-sm rounded-lg border focus:ring focus:ring-blue-200">
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\Category::select('id', 'name')->get() as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <select wire:model.defer="sort" class="px-3 py-2 text-sm rounded-lg border focus:ring focus:ring-blue-200">
                <option value="latest">Terbaru</option>
                <option value="oldest">Terlama</option>
            </select>

            <button type="submit"
                class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                Terapkan Filter
            </button>
        </form>
    </div>

    {{-- DESKTOP --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="border-b text-gray-500">
                <tr>
                    <th class="py-3 text-left">Produk</th>
                    <th class="py-3 text-left">Kategori</th>
                    <th class="py-3 text-left">Harga</th>
                    <th class="py-3 text-left">Status</th>
                    <th class="py-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                                <tr class="border-b hover:bg-gray-50 align-middle">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <img class="w-12 h-12 rounded object-cover" src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_url)
                        : asset('img/placeholder-car.png')}}">
                                            <span class="font-medium">{{ $product->name }}</span>
                                        </div>
                                    </td>

                                    <td class="py-4">{{ $product->category->name ?? '-' }}</td>

                                    <td class="py-4">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>

                                    <td class="py-4">
                                        <span @class([
                                            'px-2 py-1 rounded text-xs',
                                            'bg-green-100 text-green-700' => $product->status === 'available',
                                            'bg-amber-100 text-amber-700' => $product->status === 'unavailable',
                                            'bg-gray-100 text-gray-600' => $product->status === 'sold',
                                        ])>
                                            {{ match ($product->status) {
                        'available' => 'Tersedia',
                        'unavailable' => 'Tidak tersedia',
                        'sold' => 'Terjual',
                        default => ucfirst($product->status),
                    } }}
                                        </span>
                                    </td>

                                    <td class="py-4">
                                        <div class="flex gap-2">
                                            <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:underline">
                                                <i class="fa-solid fa-pen-to-square fa-xl"></i>
                                            </a>
                                            <button wire:click="delete({{ $product->id }})"
                                                wire:confirm="Yakin ingin menghapus produk ini?" class="text-red-600 hover:underline">
                                                <i class="fa-solid fa-trash fa-xl"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500">
                            Tidak ada produk
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE --}}
    <div class="md:hidden space-y-3">
        @foreach ($products as $product)
            <div class="border rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <img src="{{ $product->primaryImage?->image_url ?? '/placeholder.png' }}"
                        class="w-14 h-14 rounded object-cover">
                    <div>
                        <h3 class="font-semibold text-sm">{{ $product->name }}</h3>
                        <p class="text-xs text-gray-500">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="flex justify-between mt-3 text-sm">
                    <a href="{{ route('products.edit', $product) }}"
                        class="text-primary hover:underline inline-flex items-center gap-1">
                        <i class="fa-solid fa-pen-to-square"></i>
                        Edit
                    </a>
                    <button wire:click="delete({{ $product->id }})" wire:confirm="Yakin ingin menghapus produk ini?"
                        class="text-red-600 inline-flex items-center gap-1">
                        <i class="fa-solid fa-trash"></i>
                        Hapus
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>