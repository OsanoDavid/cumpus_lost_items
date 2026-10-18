<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            // PostgreSQL: safely alter the enum column to boolean
            DB::statement('ALTER TABLE items DROP CONSTRAINT IF EXISTS items_is_resolved_check;');
            DB::statement('ALTER TABLE items ALTER COLUMN is_resolved DROP DEFAULT;');
            DB::statement("ALTER TABLE items ALTER COLUMN is_resolved TYPE BOOLEAN USING CASE WHEN is_resolved::text = '1' THEN TRUE ELSE FALSE END;");
            DB::statement('ALTER TABLE items ALTER COLUMN is_resolved SET DEFAULT FALSE;');
            DB::statement('ALTER TABLE items ALTER COLUMN is_resolved SET NOT NULL;');
        }
        // SQLite: The column was already created as boolean in the create_items migration
        // or the add_missing_columns migration, so no action needed.
    }

    public function down(): void
    {
        //
    }
};