<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();

        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('types')->restrictOnDelete();
            $table->string('name')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('types');
    }
};
