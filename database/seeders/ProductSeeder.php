<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Electronic 1',
            'price' => 10.00,
            'stock' => 10,
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'Electronic 2',
            'price' => 15.50,
            'stock' => 15,
            'category_id' => 1,

        ]);

        Product::create([
            'name' => 'Clothing 1',
            'price' => 25.00,
            'stock' => 20,
            'category_id' => 2,
        ]);
        Product::create([
            'name' => 'Toy 1',
            'price' => 20.00,
            'stock' => 40,
            'category_id' => 4,
        ]);
        Product::create([
            'name' => 'Book 1',
            'price' => 15.00,
            'stock' => 20,
            'category_id' => 3,
        ]);
        Product::create([
            'name' => 'Book 2',
            'price' => 10.00,
            'stock' => 50,
            'category_id' => 3,
        ]);
    }
}
