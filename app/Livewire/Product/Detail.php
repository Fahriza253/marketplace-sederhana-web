<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class Detail extends Component
{
    public Product $product;

    public int $activeImage = 0;
    public string $activeTab = 'description';

    public function mount(Product $product): void
    {
        $this->product->load([
            'images:id,product_id,image_url',
            'seller:id,name',
            'vehicle',
            'category:id,name',
        ]);
    }

    public function selectImage(int $index): void
    {
        $this->activeImage = $index;
    }

    public function getImagesProperty(): array
    {
        return $this->product->images
            ->pluck('image_url')
            ->map(fn ($url) => asset('storage/' . $url))
            ->toArray();
    }

    public function render()
    {
        return view('livewire.product.detail', [
            'images' => $this->images,
        ]);
    }
}
