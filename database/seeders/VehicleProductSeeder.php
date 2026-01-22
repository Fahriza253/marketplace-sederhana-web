<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    User,
    Role,
    Type,
    Category,
    Product,
    VehicleProduct,
    Image
};
use Illuminate\Support\Facades\Hash;

class VehicleProductSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::firstOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name'     => 'Demo Seller',
                'password' => Hash::make('password'),
            ]
        );

        $roleSeller = Role::firstOrCreate(['name' => 'seller']);
        $seller->roles()->syncWithoutDetaching($roleSeller->id);

        /* CATEGORY */
        $vehicleType = Type::firstOrCreate(['name' => 'Vehicle']);

        $carCategory = Category::firstOrCreate([
            'type_id' => $vehicleType->id,
            'name'    => 'Kendaraan',
        ]);

        // Define an array of possible image URLs
        $imageUrls = [
            'products/placeholder-car1.jpg',
            'products/placeholder-car2.jpg',
            'products/placeholder-car3.jpg',
            'products/placeholder-car4.jpg',
            'products/placeholder-car5.jpg',
            'products/placeholder-car6.jpg',
            'products/placeholder-car7.jpg',
            'products/placeholder-car8.jpg',
            'products/placeholder-car9.jpg',
            'products/placeholder-car10.jpg',
        ];

        /* PRODUCTS */
        Product::factory()
            ->count(100)
            ->state([
                'user_id'     => $seller->id,
                'category_id' => $carCategory->id,
            ])
            ->create()
            ->each(function (Product $product) use ($imageUrls) {
                VehicleProduct::factory()->create([
                    'product_id' => $product->id,
                ]);
                $randomImage = $imageUrls[array_rand($imageUrls)];
                Image::create([
                    'product_id' => $product->id,
                    'image_url'  => $randomImage,
                    'is_primary' => true,
                ]);
            });
    }
}
