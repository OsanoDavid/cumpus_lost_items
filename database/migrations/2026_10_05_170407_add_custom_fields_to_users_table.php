<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('reg_number')->unique()->nullable();
            $table->string('course')->nullable();
            $table->string('year_of_study')->nullable();
            $table->string('school')->nullable();
            $table->text('reason_for_registering')->nullable();
            $table->text('what_lost')->nullable();
            $table->text('what_searching')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'reg_number', 'course', 'year_of_study', 'school', 
                'reason_for_registering', 'what_lost', 'what_searching'
            ]);
        });
    }
};