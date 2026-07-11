<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\VehicleProduct;

class Edit extends Component
{
    use WithFileUploads;

    public Product $product;

    // Product
    public string $name;
    public string $description;
    public float  $price;
    public int    $stock;
    public string $status;
    public string $condition;
    public int    $category_id;

    // Vehicle
    public string $brand;
    public string $model;
    public int    $year;
    public string $engine_capacity = '';
    public string $license_plate = '';

    // Images
    public array $newImages = [];

    /**
     * Single source of truth:
     * ['type' => 'old'|'new', 'value' => id|index]
     */
    public ?array $primary = null;

    public function mount(Product $product)
    {
        $user = Auth::user();
        if ($user->hasRole('seller') && ! $user->hasRole('admin') && $product->user_id !== Auth::id()) {
            abort(403);
        }

        $product->load(['vehicle', 'images']);
        $this->product = $product;

        $this->fill([
            'name'        => $product->name,
            'description' => $product->description,
            'price'       => $product->price,
            'stock'       => $product->stock,
            'status'      => $product->status,
            'condition'   => $product->condition,
            'category_id' => $product->category_id,
        ]);

        if ($product->vehicle) {
            $this->brand = (string) ($product->vehicle->brand ?? '');
            $this->model = (string) ($product->vehicle->model ?? '');
            $this->year = (int) ($product->vehicle->year ?? now()->year);
            $this->engine_capacity = (string) ($product->vehicle->engine_capacity ?? '');
            $this->license_plate = (string) ($product->vehicle->license_plate ?? '');
        }

        if ($product->primaryImage) {
            $this->primary = [
                'type'  => 'old',
                'value' => $product->primaryImage->id,
            ];
        }
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|min:5',
            'price' => 'required|numeric|min:1000',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable,sold',
            'condition' => 'required|in:new,used',
            'category_id' => 'required|exists:categories,id',

            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|integer|min:1990',
            'engine_capacity' => 'required',
            'license_plate' => 'nullable|string|max:20',

            'newImages.*' => 'image|max:2048',
        ];
    }

    /* ================= IMAGE STATE ================= */

    public function setPrimaryOld(int $imageId): void
    {
        $this->primary = [
            'type'  => 'old',
            'value' => $imageId,
        ];
    }

    public function setPrimaryNew(int $index): void
    {
        $this->primary = [
            'type'  => 'new',
            'value' => $index,
        ];
    }

    public function removeNewImage(int $index): void
    {
        array_splice($this->newImages, $index, 1);

        if ($this->primary && $this->primary['type'] === 'new') {
            if ($this->primary['value'] === $index) {
                $this->primary = null;
            } elseif ($this->primary['value'] > $index) {
                $this->primary['value']--;
            }
        }
    }

    /* ================= SAVE ================= */

    public function save()
{
    $this->validate();

    DB::transaction(function () {

        $this->product->update([
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'stock'       => $this->stock,
            'status'      => $this->status,
            'condition'   => $this->condition,
            'category_id' => $this->category_id,
            'sold_at'     => $this->status === 'sold' ? ($this->product->sold_at ?? now()) : null,
        ]);

        VehicleProduct::updateOrCreate(
            ['product_id' => $this->product->id],
            [
                'brand'           => $this->brand,
                'model'           => $this->model,
                'year'            => $this->year,
                'engine_capacity' => $this->engine_capacity,
                'license_plate'   => $this->license_plate ?: null,
            ]
        );

        /* ================= IMAGES ================= */

        // 1️⃣ Upload new images (default is_primary = false)
        $newImageIds = [];
        foreach ($this->newImages as $index => $image) {
            $path = $image->store('products', 'public');

            $img = Image::create([
                'product_id' => $this->product->id,
                'image_url'  => $path,
                'is_primary' => false,
            ]);

            $newImageIds[$index] = $img->id;
        }

        // 2️⃣ Cari primary lama (jika ada)
        $currentPrimary = Image::where('product_id', $this->product->id)
            ->where('is_primary', true)
            ->first();

        // 3️⃣ Tentukan target primary baru
        $newPrimaryId = null;

        if ($this->primary) {
            if ($this->primary['type'] === 'old') {
                $newPrimaryId = $this->primary['value'];
            }

            if (
                $this->primary['type'] === 'new'
                && isset($newImageIds[$this->primary['value']])
            ) {
                $newPrimaryId = $newImageIds[$this->primary['value']];
            }
        }

        // 4️⃣ Unset primary lama (SATU ROW SAJA)
        if ($currentPrimary && $currentPrimary->id !== $newPrimaryId) {
            $currentPrimary->update(['is_primary' => false]);
        }

        // 5️⃣ Set primary baru
        if ($newPrimaryId) {
            Image::where('id', $newPrimaryId)
                ->update(['is_primary' => true]);
        }

        // 6️⃣ Fallback: jika tidak ada primary sama sekali
        if (!$newPrimaryId && !$currentPrimary) {
            Image::where('product_id', $this->product->id)
                ->orderBy('id')
                ->limit(1)
                ->update(['is_primary' => true]);
        }
    });

    session()->flash('success', 'Produk berhasil diperbarui');
    return redirect()->route('products.index');
}

    public function render()
    {
        return view('livewire.product.edit', [
            'categories' => Category::all(),
        ]);
    }
}
