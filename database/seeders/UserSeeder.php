<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole     = Role::where('name', 'admin')->firstOrFail();
        $consumentRole = Role::where('name', 'consument')->firstOrFail();

        /* ================= ADMIN ================= */
        $admin = User::firstOrCreate(
            ['email' => 'admin@marketplace.test'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('admin123'),
                'phone_number' => '081234567890',
                'email_verified_at' => now(),
            ]
        );

        $admin->roles()->syncWithoutDetaching($adminRole->id);

        /* ================= CONSUMENT ================= */
        User::factory()
            ->count(10)
            ->create()
            ->each(function (User $user) use ($consumentRole) {
                $user->roles()->syncWithoutDetaching($consumentRole->id);
            });
    }
}
