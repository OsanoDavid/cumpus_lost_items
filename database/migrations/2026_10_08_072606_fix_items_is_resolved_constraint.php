<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop the check constraint if it exists
        DB::statement('ALTER TABLE items DROP CONSTRAINT IF EXISTS items_is_resolved_check;');

        // 2. Drop the old default value so PostgreSQL allows the type change
        DB::statement('ALTER TABLE items ALTER COLUMN is_resolved DROP DEFAULT;');

        // 3. Safely alter the column type to boolean using PostgreSQL's USING clause
        DB::statement('ALTER TABLE items ALTER COLUMN is_resolved TYPE BOOLEAN USING CASE WHEN is_resolved::text = \'1\' THEN TRUE ELSE FALSE END;');
        
        // 4. Set the new boolean default value and make it non-nullable
        DB::statement('ALTER TABLE items ALTER COLUMN is_resolved SET DEFAULT FALSE;');
        DB::statement('ALTER TABLE items ALTER COLUMN is_resolved SET NOT NULL;');
    }

    public function down(): void
    {
        //
    }
};