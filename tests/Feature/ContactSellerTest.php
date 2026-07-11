<?php

namespace Tests\Feature;

use App\Livewire\Product\Detail;
use App\Models\Category;
use App\Models\Finance;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContactSellerTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_seller_records_lead_and_opens_whatsapp(): void
    {
        $seller = User::factory()->create([
            'phone_number' => '081234567891',
        ]);

        $type = Type::create(['name' => 'Vehicle']);
        $category = Category::create([
            'type_id' => $type->id,
            'name' => 'Kendaraan',
        ]);

        $product = Product::factory()->create([
            'user_id' => $seller->id,
            'category_id' => $category->id,
            'price' => 250_000_000,
            'status' => 'available',
            'stock' => 1,
        ]);

        Livewire::test(Detail::class, ['product' => $product])
            ->call('contactSeller')
            ->assertHasNoErrors()
            ->assertOk();

        $this->assertDatabaseCount('transactions', 1);
        $this->assertDatabaseCount('transaction_items', 1);
        $this->assertDatabaseCount('finances', 1);

        $this->assertSame('whatsapp', Transaction::first()->channel);
        $this->assertSame('250000000.00', (string) Finance::first()->amount);
    }

    public function test_contact_seller_without_phone_shows_error(): void
    {
        $seller = User::factory()->create([
            'phone_number' => null,
        ]);

        $type = Type::create(['name' => 'Vehicle']);
        $category = Category::create([
            'type_id' => $type->id,
            'name' => 'Kendaraan',
        ]);

        $product = Product::factory()->create([
            'user_id' => $seller->id,
            'category_id' => $category->id,
            'status' => 'available',
            'stock' => 1,
        ]);

        Livewire::test(Detail::class, ['product' => $product])
            ->call('contactSeller')
            ->assertHasErrors(['contact']);

        $this->assertDatabaseCount('transactions', 0);
    }
}
