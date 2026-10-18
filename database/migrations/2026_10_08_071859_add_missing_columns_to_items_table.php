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
        Schema::table('items', function (Blueprint $table) {
        if (!Schema::hasColumn('items', 'title')) {
            $table->string('title');
        }
        if (!Schema::hasColumn('items', 'status')) {
            $table->string('status');
        }
        if (!Schema::hasColumn('items', 'category')) {
            $table->string('category');
        }
        if (!Schema::hasColumn('items', 'location')) {
            $table->string('location');
        }
        if (!Schema::hasColumn('items', 'secret_identifier')) {
            $table->string('secret_identifier')->nullable();
        }
        if (!Schema::hasColumn('items', 'is_resolved')) {
            $table->boolean('is_resolved')->default(false);
        }
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }
};
