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
        DB::table('products')->insert([
            ['name' => 'iPhone 14', 'description' => 'Latest flagship smartphone from Apple', 'product_type_id' => 1],
            ['name' => 'Samsung Galaxy S23', 'description' => 'High-end Android smartphone from Samsung', 'product_type_id' => 1],
            ['name' => 'Levi\'s Jeans', 'description' => 'Classic denim jeans from Levi\'s', 'product_type_id' => 2],
            ['name' => 'IKEA Sofa', 'description' => 'Modern sofa from IKEA', 'product_type_id' => 3],
            ['name' => 'Harry Potter Books', 'description' => 'The complete Harry Potter series', 'product_type_id' => 4],
            ['name' => 'LEGO Building Blocks', 'description' => 'Colorful building blocks for kids', 'product_type_id' => 5],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('products')->truncate();
    }
};
