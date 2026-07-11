<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Widen amount columns for existing databases.
 * Fresh installs already use decimal(15,2) from 007_create_transactions_table.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement('ALTER TABLE transactions ALTER COLUMN total_amount TYPE numeric(15, 2)');
        DB::statement('ALTER TABLE transaction_items ALTER COLUMN price TYPE numeric(15, 2)');
        DB::statement('ALTER TABLE transaction_items ALTER COLUMN subtotal TYPE numeric(15, 2)');
        DB::statement('ALTER TABLE finances ALTER COLUMN amount TYPE numeric(15, 2)');
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement('ALTER TABLE transactions ALTER COLUMN total_amount TYPE numeric(10, 2)');
        DB::statement('ALTER TABLE transaction_items ALTER COLUMN price TYPE numeric(10, 2)');
        DB::statement('ALTER TABLE transaction_items ALTER COLUMN subtotal TYPE numeric(10, 2)');
        DB::statement('ALTER TABLE finances ALTER COLUMN amount TYPE numeric(10, 2)');
    }
};
