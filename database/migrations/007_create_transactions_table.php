<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('buyer_name')->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->enum('payment_method', ['credit_card', 'bank_transfer', 'e_wallet'])->default('bank_transfer');
            $table->enum('channel', ['whatsapp'])->default('whatsapp');
            $table->timestamps();
            $table->index('created_at');
        });

        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->restrictOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('price', 15, 2);
            $table->decimal('subtotal', 15, 2);
        });

        Schema::create('finances', function (Blueprint $table) {
            $table->id('finance_id');
            $table->foreignId('transaction_id')->constrained('transactions')->restrictOnDelete();
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->timestamp('recorded_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('transaction_items');
        Schema::dropIfExists('finances');
    }
};
