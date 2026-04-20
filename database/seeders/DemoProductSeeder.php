<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DemoProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $cake = Category::create(['name' => 'Cake', 'description' => 'Kue Ulang Tahun']);
        $cupcake = Category::create(['name' => 'CupCake', 'description' => 'Cupcake']);
        $bento = Category::create(['name' => 'Bento', 'description' => 'Bento Cake']);
        $milkshake = Category::create(['name' => 'Milkshake', 'description' => 'Milkshake']);
        $roti = Category::create(['name' => 'Roti', 'description' => 'Roti']);
        $minuman = Category::create(['name' => 'Minuman', 'description' => 'Minuman']);

        // Create Products
        $products = [
            ['name' => 'Kue Angka Strawberry', 'price' => 300000, 'category_id' => $cake->id, 'image' => 'images/products/1.jpg'],
            ['name' => 'Fondant Cake', 'price' => 199000, 'category_id' => $cake->id, 'image' => 'images/products/2.jpg'],
            ['name' => 'Flowers Cake', 'price' => 160000, 'category_id' => $cake->id, 'image' => 'images/products/3.jpg'],
            ['name' => 'Bento Cake', 'price' => 45000, 'category_id' => $bento->id, 'image' => 'images/products/4.jpg'],
            ['name' => 'Blue Gold Cake', 'price' => 140500, 'category_id' => $cake->id, 'image' => 'images/products/5.jpg'],
            ['name' => 'Thomas Cake', 'price' => 110000, 'category_id' => $cake->id, 'image' => null],
            ['name' => 'Lion Fondant Cake', 'price' => 155000, 'category_id' => $cake->id, 'image' => null],
            ['name' => 'Blue Bento Cake', 'price' => 40000, 'category_id' => $bento->id, 'image' => null],
            ['name' => 'Kuromi Pink Cake', 'price' => 179000, 'category_id' => $cake->id, 'image' => null],
            ['name' => 'Wedding Cake', 'price' => 250000, 'category_id' => $cake->id, 'image' => null],
            ['name' => 'Cupcake', 'price' => 154000, 'category_id' => $cupcake->id, 'image' => null],
            ['name' => 'Two Cake', 'price' => 200000, 'category_id' => $cake->id, 'image' => null],
            ['name' => 'Bento Cupcake', 'price' => 180000, 'category_id' => $cupcake->id, 'image' => null],
            ['name' => 'Tullip Cake', 'price' => 175000, 'category_id' => $cake->id, 'image' => null],
            ['name' => 'Mix Strawberry', 'price' => 145000, 'category_id' => $cake->id, 'image' => null],
        ];

        foreach ($products as $idx => $p) {
            Product::create([
                'category_id' => $p['category_id'],
                'name' => $p['name'],
                'code' => 'PRD-' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT),
                'stock' => 10,
                'price' => $p['price'],
                'description' => $p['name'],
                'image' => $p['image'] ?? null,
            ]);
        }
    }
}
