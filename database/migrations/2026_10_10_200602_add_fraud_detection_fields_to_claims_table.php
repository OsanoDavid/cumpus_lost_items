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
        Schema::table('claims', function (Blueprint $table) {
            if (!Schema::hasColumn('claims', 'claimed_loss_date')) {
                $table->date('claimed_loss_date')->nullable();
            }
            if (!Schema::hasColumn('claims', 'claimed_location')) {
                $table->string('claimed_location')->nullable();
            }
            if (!Schema::hasColumn('claims', 'is_suspicious')) {
                $table->boolean('is_suspicious')->default(false);
            }
            if (!Schema::hasColumn('claims', 'flag_reason')) {
                $table->text('flag_reason')->nullable();
            }
            if (!Schema::hasColumn('claims', 'admin_notes')) {
                $table->text('admin_notes')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropColumn([
                'claimed_loss_date',
                'claimed_location',
                'is_suspicious',
                'flag_reason',
                'admin_notes',
            ]);
        });
    }
};

