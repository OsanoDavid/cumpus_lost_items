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
            // PostgreSQL: safely alter the enum column to boolean if needed
            $columnType = DB::selectOne("
                SELECT data_type 
                FROM information_schema.columns 
                WHERE table_name = 'items' AND column_name = 'is_resolved'
            ");
            if ($columnType && $columnType->data_type !== 'boolean') {
                DB::statement('ALTER TABLE items DROP CONSTRAINT IF EXISTS items_is_resolved_check;');
                DB::statement('ALTER TABLE items ALTER COLUMN is_resolved DROP DEFAULT;');
                DB::statement("ALTER TABLE items ALTER COLUMN is_resolved TYPE BOOLEAN USING CASE WHEN is_resolved::text = '1' OR is_resolved::text = 'resolved' THEN TRUE ELSE FALSE END;");
                DB::statement('ALTER TABLE items ALTER COLUMN is_resolved SET DEFAULT FALSE;');
                DB::statement('ALTER TABLE items ALTER COLUMN is_resolved SET NOT NULL;');
            }
        } elseif ($driver === 'sqlite') {
            Schema::table('items', function (Blueprint $table) {
                $table->boolean('is_resolved')->default(false)->change();
            });
        }
    }

    public function down(): void
    {
        //
    }
};