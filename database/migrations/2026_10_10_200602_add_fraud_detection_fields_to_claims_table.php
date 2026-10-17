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
            $table->date('claimed_loss_date')->nullable()->after('proof_details');
            $table->string('claimed_location')->nullable()->after('claimed_loss_date');
            $table->boolean('is_suspicious')->default(false)->after('claimed_location');
            $table->text('flag_reason')->nullable()->after('is_suspicious');
            $table->text('admin_notes')->nullable()->after('flag_reason');
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

