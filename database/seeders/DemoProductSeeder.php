<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DemoProductSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $cake = Category::create(['name' => 'Cake', 'description' => 'Kue Ulang Tahun']);
        $cupcake = Category::create(['name' => 'CupCake', 'description' => 'Cupcake']);
        $bento = Category::create(['name' => 'Bento', 'description' => 'Bento Cake']);
        $milkshake = Category::create(['name' => 'Milkshake', 'description' => 'Milkshake']);
        $minuman = Category::create(['name' => 'Minuman', 'description' => 'Minuman']);

        // Products (gabungan)
        $products = [
            ['name' => 'Kue Angka Strawberry', 'price' => 300000, 'category_id' => $cake->id, 'stock' => 5, 'image' => 'images/products/1.jpg'],
            ['name' => 'Fondant Cake', 'price' => 199000, 'category_id' => $cake->id, 'stock' => 3, 'image' => 'images/products/2.jpg'],
            ['name' => 'Flowers Cake', 'price' => 160000, 'category_id' => $cake->id, 'stock' => 2, 'image' => 'images/products/3.jpg'],
            ['name' => 'Bento Cake', 'price' => 45000, 'category_id' => $bento->id, 'stock' => 10, 'image' => 'images/products/4.jpg'],
            ['name' => 'Blue Gold Cake', 'price' => 140500, 'category_id' => $cake->id, 'stock' => 4, 'image' => 'images/products/5.jpg'],
            ['name' => 'Milkshake Strawberry', 'price' => 15000, 'category_id' => $milkshake->id, 'stock' => 15, 'image' => null],
            ['name' => 'Air Mineral 600ml', 'price' => 5000, 'category_id' => $minuman->id, 'stock' => 50, 'image' => null],
            ['name' => 'Cupcake', 'price' => 25000, 'category_id' => $cupcake->id, 'stock' => 20, 'image' => null],
        ];

        foreach ($products as $idx => $p) {
            Product::create([
                'category_id' => $p['category_id'],
                'name' => $p['name'],
                'code' => 'PRD-' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT),
                'stock' => $p['stock'],
                'price' => $p['price'],
                'description' => $p['name'],
                'image' => $p['image'],
            ]);
        }
    }
}
