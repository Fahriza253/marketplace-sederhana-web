<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\VehicleProduct;

/**
 * TODO:
 * Fix data product
 */

class Create extends Component
{
    use WithFileUploads;

    public string $name        = '';
    public string $description = '';
    public float  $price;
    public int    $stock     = 1;
    // TODO: Set manually
    public string $condition = 'used';
    public int    $category_id;

    public string $brand = '';
    public string $model = '';
    public int    $year;
    public string $engine_capacity = '';
    public string $license_plate = '';

    public array $images = [];
    public $newImages = [];
    public int   $primaryImageIndex = 0;

    protected function rules(): array
    {
        return [
            'name' => 'required|min:5',
            'price' => 'required|numeric|min:1000',
            'stock' => 'required|integer|min:1',
            'condition' => 'required',
            'category_id' => 'required|exists:categories,id',

            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|integer',
            'engine_capacity' => 'required',

            'images'   => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'primaryImageIndex'=> 'required|integer|min:0',
        ];
    }

    public function updatedNewImages()
    {
        // Gabungkan gambar baru ke array images tanpa menghapus yang lama
        foreach ($this->newImages as $file) {
            if (count($this->images) < 5) {
                $this->images[] = $file;
            }
        }
        $this->newImages = [];
        // Reset primary jika tidak ada gambar
        if (count($this->images) === 0) {
            $this->primaryImageIndex = 0;
        }
    }

    public function removeImage($index)
    {
        array_splice($this->images, $index, 1);
        // Atur primaryImageIndex jika perlu
        if ($this->primaryImageIndex >= count($this->images)) {
            $this->primaryImageIndex = max(0, count($this->images) - 1);
        }
    }

    public function setPrimaryImage($index)
    {
        $this->primaryImageIndex = $index;
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            $product = Product::create([
                'user_id'     => Auth::id(),
                'category_id' => $this->category_id,
                'name'        => $this->name,
                'description' => $this->description,
                'price'       => $this->price,
                'stock'       => $this->stock,
                'condition'   => $this->condition,
                'status'      => 'available',
            ]);

            $product->vehicle()->create([
                'brand' => $this->brand,
                'model' => $this->model,
                'year' => $this->year,
                'engine_capacity' => $this->engine_capacity,
                // 'license_plate' => $this->license_plate,
            ]);

            foreach ($this->images as $index => $image) {
                // Pastikan nama file unik
                $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs(
                    'products/' . $product->id,
                    $filename,
                    'public'
                );

                $product->images()->create([
                    'image_url'  => $path,
                    'is_primary' => $index === $this->primaryImageIndex,
                ]);
            }
        });

        session()->flash('success', 'Produk berhasil ditambahkan');

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.product.create', [
            'categories' => Category::all(),
        ]);
    }
}
