<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Finance;

class Detail extends Component
{
    public Product $product;

    public int $activeImage = 0;
    public string $activeTab = 'description';

    public function mount(Product $product): void
    {
        $this->product->load([
            'images:id,product_id,image_url',
            'seller:id,name,phone_number',
            'vehicle',
            'category:id,name',
        ]);
    }

    public function selectImage(int $index): void
    {
        $this->activeImage = $index;
    }

    public function contactSeller(): void
    {
        $this->resetErrorBag('contact');
        $this->product->loadMissing(['seller']);

        $phone = $this->normalizeWhatsAppPhone($this->product->seller?->phone_number);

        if ($phone === null) {
            $this->addError('contact', 'Penjual belum memasang nomor WhatsApp yang valid.');

            return;
        }

        try {
            $this->recordWhatsAppLead();
        } catch (\Throwable $e) {
            Log::warning('Gagal mencatat lead WhatsApp', [
                'product_id' => $this->product->id,
                'message' => $e->getMessage(),
            ]);
        }

        $message = rawurlencode(
            'Halo, saya tertarik dengan listing: '.$this->product->name.' di '.config('app.name')
        );

        $url = 'https://wa.me/'.$phone.'?text='.$message;

        // Buka WhatsApp di tab baru agar listing tetap terbuka
        $this->js('window.open('.json_encode($url).', "_blank")');
    }

    protected function recordWhatsAppLead(): void
    {
        DB::transaction(function () {
            $buyer = Auth::user();

            $transaction = Transaction::create([
                'user_id' => $buyer?->id,
                'buyer_name' => $buyer?->name ?? 'Tamu',
                'total_amount' => $this->product->price,
                'status' => 'pending',
                'payment_method' => 'bank_transfer',
                'channel' => 'whatsapp',
            ]);

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $this->product->id,
                'quantity' => 1,
                'price' => $this->product->price,
                'subtotal' => $this->product->price,
            ]);

            Finance::create([
                'transaction_id' => $transaction->id,
                'type' => 'income',
                'amount' => $this->product->price,
                'description' => 'Lead WhatsApp: '.$this->product->name,
                'recorded_at' => now(),
            ]);
        });
    }

    protected function normalizeWhatsAppPhone(?string $raw): ?string
    {
        if ($raw === null || trim($raw) === '') {
            return null;
        }

        $phone = preg_replace('/\D+/', '', $raw);

        if ($phone === '' || strlen($phone) < 8) {
            return null;
        }

        if (str_starts_with($phone, '0')) {
            $phone = '62'.substr($phone, 1);
        } elseif (str_starts_with($phone, '8') && strlen($phone) >= 9 && strlen($phone) <= 13) {
            // Nomor lokal tanpa leading 0 (8xxxxxxxxxx)
            $phone = '62'.$phone;
        }

        return $phone;
    }

    public function getImagesProperty(): array
    {
        return $this->product->images
            ->pluck('image_url')
            ->map(fn ($url) => asset('storage/'.$url))
            ->toArray();
    }

    public function getHasSellerPhoneProperty(): bool
    {
        return $this->normalizeWhatsAppPhone($this->product->seller?->phone_number) !== null;
    }

    public function render()
    {
        return view('livewire.product.detail', [
            'images' => $this->images,
        ]);
    }
}
