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
        Schema::create('menu_item_addons', function (Blueprint $table) {
            $table->id(); // auto-increment primary key
            $table->unsignedBigInteger('menu_item_id'); // foreign key
            $table->string('name'); // varchar(255) by default
            $table->decimal('price', 10, 2);
            $table->boolean('is_available')->default(true);
            $table->timestamps(); // created_at & updated_at

            // foreign key constraint
            $table->foreign('menu_item_id')
                  ->references('id')
                  ->on('menu_items')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_addons');
    }
};
