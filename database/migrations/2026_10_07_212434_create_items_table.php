<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * This migration is intentionally a no-op.
     * The items table is created by the earlier migration (2026_10_02_094354).
     * This duplicate was causing 'table already exists' errors on fresh deployments.
     */
    public function up(): void
    {
        // No-op: items table is created by 2026_10_02_094354_create_items_table.php
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
