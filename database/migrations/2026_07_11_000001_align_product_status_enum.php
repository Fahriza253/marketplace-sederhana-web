<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Align existing databases created before sold status was added.
 * Fresh installs already get the enum from 006_create_products_table.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS products_status_check');
        DB::statement("ALTER TABLE products ADD CONSTRAINT products_status_check CHECK (status::text = ANY (ARRAY['available'::character varying, 'unavailable'::character varying, 'sold'::character varying]::text[]))");
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS products_status_check');
        DB::statement("ALTER TABLE products ADD CONSTRAINT products_status_check CHECK (status::text = ANY (ARRAY['available'::character varying, 'unavailable'::character varying]::text[]))");
    }
};
