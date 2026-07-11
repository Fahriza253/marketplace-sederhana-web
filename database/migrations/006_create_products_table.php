<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->nullOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();/*->index();*/
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->enum('status', ['available', 'unavailable', 'sold'])->default('available');
            $table->enum('condition', ['new', 'used'])->default('new');
            $table->timestamp('sold_at')->nullable();
            $table->timestamps();
        });

        Schema::create('vehicle_products', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->year('year')->nullable();
            $table->string('engine_capacity')->nullable();
            $table->string('license_plate')->nullable()->unique();
        });

        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->string('image_url');
            $table->boolean('is_primary')->default(false);
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement("
                CREATE UNIQUE INDEX images_primary_unique
                ON images (product_id)
                WHERE is_primary = true
            ");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS images_primary_unique');
        }

        Schema::dropIfExists('images');
        Schema::dropIfExists('vehicle_products');
        Schema::dropIfExists('products');
    }
};
