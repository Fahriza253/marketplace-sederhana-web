<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    User,
    Role,
    Type,
    Category,
    Product,
    VehicleProduct,
    Image
};

class VehicleProductSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::firstOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name' => 'Demo Seller',
                'password' => Hash::make('password'),
                'phone_number' => '081234567891',
            ]
        );

        if (! $seller->phone_number) {
            $seller->update(['phone_number' => '081234567891']);
        }

        $roleSeller = Role::firstOrCreate(['name' => 'seller']);
        $seller->roles()->syncWithoutDetaching($roleSeller->id);

        $vehicleType = Type::firstOrCreate(['name' => 'Vehicle']);

        $carCategory = Category::firstOrCreate([
            'type_id' => $vehicleType->id,
            'name' => 'Kendaraan',
        ]);

        $imagePaths = $this->ensureDemoImages();

        Product::factory()
            ->count(100)
            ->state([
                'user_id' => $seller->id,
                'category_id' => $carCategory->id,
            ])
            ->create()
            ->each(function (Product $product) use ($imagePaths) {
                VehicleProduct::factory()->create([
                    'product_id' => $product->id,
                ]);

                $source = $imagePaths[array_rand($imagePaths)];
                $dest = 'products/'.$product->id.'/primary.svg';
                Storage::disk('public')->put($dest, File::get(Storage::disk('public')->path($source)));

                Image::create([
                    'product_id' => $product->id,
                    'image_url' => $dest,
                    'is_primary' => true,
                ]);
            });
    }

    /**
     * @return list<string>
     */
    protected function ensureDemoImages(): array
    {
        $disk = Storage::disk('public');
        $disk->makeDirectory('products/demo');

        $palette = [
            ['#0f4c6e', '#e8a317'],
            ['#1b6392', '#f3f7fa'],
            ['#12263a', '#e8a317'],
            ['#0f4c6e', '#7eb8d4'],
            ['#163d56', '#e8a317'],
        ];

        $paths = [];

        foreach ($palette as $i => [$bg, $accent]) {
            $relative = 'products/demo/car-'.($i + 1).'.svg';
            $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="800" height="500" viewBox="0 0 800 500">
  <rect width="800" height="500" fill="{$bg}"/>
  <rect x="140" y="220" width="520" height="110" rx="26" fill="{$accent}"/>
  <circle cx="250" cy="345" r="40" fill="#12263a"/>
  <circle cx="550" cy="345" r="40" fill="#12263a"/>
  <path d="M200 220 L270 150 H500 L620 220" fill="#ffffff" opacity=".85"/>
  <text x="400" y="80" text-anchor="middle" fill="#ffffff" font-family="system-ui,sans-serif" font-size="32" font-weight="700">DriveHub Demo</text>
</svg>
SVG;
            $disk->put($relative, $svg);
            $paths[] = $relative;
        }

        return $paths;
    }
}
