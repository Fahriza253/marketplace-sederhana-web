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
        /* ================= USER (SELLER) ================= */
        $seller = User::firstOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name'     => 'Demo Seller',
                'password' => Hash::make('password'),
            ]
        );

        $roleSeller = Role::firstOrCreate(['name' => 'seller']);
        $seller->roles()->syncWithoutDetaching($roleSeller->id);

        /* ================= CATEGORY ================= */
        $vehicleType = Type::firstOrCreate(['name' => 'Vehicle']);

        $carCategory = Category::firstOrCreate([
            'type_id' => $vehicleType->id,
            'name'    => 'Kendaraan',
        ]);

        /* ================= PRODUCTS ================= */
        Product::factory()
            ->count(50)
            ->state([
                'user_id'     => $seller->id,
                'category_id' => $carCategory->id,
            ])
            ->create()
            ->each(function (Product $product) {

                /* ================= VEHICLE DETAIL ================= */
                VehicleProduct::factory()->create([
                    'product_id' => $product->id,
                ]);

                /* ================= IMAGES ================= */
                Image::create([
                    'product_id' => $product->id,
                    'image_url'       => 'products/placeholder-car.png',
                    'is_primary' => true,
                ]);
            });
    }
}
