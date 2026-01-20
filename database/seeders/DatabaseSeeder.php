<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VehicleProduct;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            VehicleProductSeeder::class,
        ]);
    }
}
