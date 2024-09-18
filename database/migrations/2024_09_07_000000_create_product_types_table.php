<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->integer('quantity');
            $table->timestamps();
        });
        // Insert initial data into the product_types table
        DB::table('product_types')->insert([
            ['name' => 'Electronics', 'description' => 'Electronic devices and accessories','quantity'=>0],
            ['name' => 'Clothing', 'description' => 'Apparel and fashion items', 'quantity'=>0],
            ['name' => 'Furniture', 'description' => 'Home furnishings and decor', 'quantity'=>0],
            ['name' => 'Books', 'description' => 'Literature, textbooks, and other printed materials', 'quantity'=>0],
            ['name' => 'Toys', 'description' => 'Games, puzzles, and other playthings', 'quantity'=>0],
        ]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_types');
    }
};
