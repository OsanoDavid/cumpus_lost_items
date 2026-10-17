<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
       public function schemaUp()
{
    Schema::create('items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('item_name');
        $table->string('category'); // e.g., Student IDs, Electronics, Books, Personal Items
        $table->string('location_found');
        $table->text('description');
        $table->string('image_path')->nullable();
        $table->enum('status', ['Unclaimed', 'Claimed'])->default('Unclaimed');
        $table->timestamps();
    });
}
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
