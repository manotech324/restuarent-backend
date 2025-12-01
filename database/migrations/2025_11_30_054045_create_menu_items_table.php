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
         Schema::create('menu_items', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('category_id')->constrained('menu_categories')->onDelete('cascade'); // Foreign key
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null'); // Optional branch
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
