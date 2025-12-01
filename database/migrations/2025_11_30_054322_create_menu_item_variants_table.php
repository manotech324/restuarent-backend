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
         Schema::create('menu_item_variants', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('menu_item_id')->constrained('menu_items')->onDelete('cascade'); // Foreign key
            $table->string('name', 100);
            $table->decimal('price', 10, 2);
            $table->boolean('is_available')->default(true);
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_variants');
    }
};
