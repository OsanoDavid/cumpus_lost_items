<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        Schema::table('items', function (Blueprint $table) use ($driver) {
            if (!Schema::hasColumn('items', 'date_lost_found')) {
                if ($driver === 'pgsql') {
                    $table->date('date_lost_found')->nullable()->after('location');
                } else {
                    $table->date('date_lost_found')->nullable();
                }
            }
            if (!Schema::hasColumn('items', 'is_anonymous')) {
                if ($driver === 'pgsql') {
                    $table->boolean('is_anonymous')->default(false)->after('is_resolved');
                } else {
                    $table->boolean('is_anonymous')->default(false);
                }
            }
        });

        // Make user_id nullable
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) use ($driver) {
            if (!Schema::hasColumn('users', 'phone')) {
                if ($driver === 'pgsql') {
                    $table->string('phone')->nullable()->after('email');
                } else {
                    $table->string('phone')->nullable();
                }
            }
            if (!Schema::hasColumn('users', 'is_admin')) {
                if ($driver === 'pgsql') {
                    $table->boolean('is_admin')->default(false)->after('phone');
                } else {
                    $table->boolean('is_admin')->default(false);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['date_lost_found', 'is_anonymous']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'is_admin']);
        });
    }
};