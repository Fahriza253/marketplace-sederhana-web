<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_assigns_consument_role(): void
    {
        Role::firstOrCreate(['name' => 'consument']);

        $response = $this->post('/register', [
            'name' => 'Buyer Demo',
            'email' => 'buyer@example.com',
            'phone_number' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));

        $user = User::where('email', 'buyer@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('consument'));
    }

    public function test_consumer_cannot_access_dashboard_products(): void
    {
        $role = Role::firstOrCreate(['name' => 'consument']);
        $user = User::factory()->create();
        $user->roles()->attach($role);

        $this->actingAs($user)
            ->get(route('products.index'))
            ->assertForbidden();
    }

    public function test_seller_can_access_dashboard(): void
    {
        $role = Role::firstOrCreate(['name' => 'seller']);
        $user = User::factory()->create();
        $user->roles()->attach($role);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();
    }

    public function test_seller_cannot_edit_another_sellers_product(): void
    {
        $sellerRole = Role::firstOrCreate(['name' => 'seller']);

        $owner = User::factory()->create();
        $owner->roles()->attach($sellerRole);

        $intruder = User::factory()->create();
        $intruder->roles()->attach($sellerRole);

        $type = Type::create(['name' => 'Vehicle']);
        $category = Category::create([
            'type_id' => $type->id,
            'name' => 'Kendaraan',
        ]);

        $product = Product::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        $this->actingAs($intruder)
            ->get(route('products.edit', $product))
            ->assertForbidden();
    }

    public function test_search_page_returns_successful_response(): void
    {
        $this->get(route('search', ['q' => 'toyota']))
            ->assertOk();
    }

    public function test_landing_page_returns_successful_response(): void
    {
        $this->get(route('landing'))
            ->assertOk();
    }
}
