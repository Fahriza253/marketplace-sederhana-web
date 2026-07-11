<div class="pt-24 max-w-7xl mx-auto px-4 py-8 space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-display font-semibold text-ink">Finance — Lead WhatsApp</h1>
            <p class="text-slate-600 text-sm">
                Catatan minat pembeli yang menghubungi via WhatsApp (bukan transaksi pembayaran).
            </p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-sm text-primary hover:underline inline-flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke dashboard
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b text-slate-500 bg-slate-50">
                    <tr>
                        <th class="py-3 px-4 text-left">Waktu</th>
                        <th class="py-3 px-4 text-left">Produk</th>
                        <th class="py-3 px-4 text-left">Pembeli</th>
                        <th class="py-3 px-4 text-left">Nilai listing</th>
                        <th class="py-3 px-4 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leads as $lead)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="py-3 px-4 whitespace-nowrap">{{ $lead->created_at?->format('d M Y H:i') }}</td>
                            <td class="py-3 px-4">
                                {{ $lead->items->first()?->product?->name ?? '-' }}
                            </td>
                            <td class="py-3 px-4">{{ $lead->buyer_name ?: ($lead->user?->name ?? 'Tamu') }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($lead->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                <span
                                    class="px-2 py-1 rounded text-xs bg-amber-100 text-amber-800">{{ $lead->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-500">
                                Belum ada lead. Lead tercatat saat pembeli menekan “Hubungi Penjual”.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="md:hidden divide-y">
            @forelse ($leads as $lead)
                <div class="p-4 space-y-1">
                    <p class="font-medium">{{ $lead->items->first()?->product?->name ?? '-' }}</p>
                    <p class="text-xs text-slate-500">{{ $lead->created_at?->format('d M Y H:i') }}</p>
                    <p class="text-sm">{{ $lead->buyer_name ?: ($lead->user?->name ?? 'Tamu') }}</p>
                    <p class="text-sm text-primary font-semibold">Rp {{ number_format($lead->total_amount, 0, ',', '.') }}
                    </p>
                </div>
            @empty
                <p class="p-8 text-center text-slate-500 text-sm">Belum ada lead.</p>
            @endforelse
        </div>
    </div>

    <div>{{ $leads->links() }}</div>
</div>