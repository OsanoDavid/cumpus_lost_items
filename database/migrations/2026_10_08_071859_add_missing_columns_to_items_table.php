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
            $table->string('title')->after('user_id');
        }
        if (!Schema::hasColumn('items', 'status')) {
            $table->string('status')->after('title');
        }
        if (!Schema::hasColumn('items', 'category')) {
            $table->string('category')->after('status');
        }
        if (!Schema::hasColumn('items', 'location')) {
            $table->string('location')->after('category');
        }
        if (!Schema::hasColumn('items', 'secret_identifier')) {
            $table->string('secret_identifier')->nullable()->after('image_path');
        }
        if (!Schema::hasColumn('items', 'is_resolved')) {
            $table->boolean('is_resolved')->default(false)->after('secret_identifier');
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
