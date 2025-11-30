<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        $birthday = Category::create(['name' => 'Birthday', 'description' => 'Birthday Package']);
        $minuman = Category::create(['name' => 'Minuman', 'description' => 'Minuman']);

        // Create Products
        Product::create([
            'category_id' => $cake->id,
            'name' => 'Under The Sea Birthday Cake',
            'code' => 'BC-04',
            'stock' => 0,
            'price' => 220000,
            'description' => 'Kue ulang tahun tema under the sea',
        ]);

        Product::create([
            'category_id' => $cake->id,
            'name' => 'White Rose Birthday Cake',
            'code' => 'BC-03',
            'stock' => 0,
            'price' => 280000,
            'description' => 'Kue ulang tahun dengan hiasan bunga mawar putih',
        ]);

        Product::create([
            'category_id' => $cake->id,
            'name' => 'White Emoji Birthday Cake',
            'code' => 'BC-02',
            'stock' => 2,
            'price' => 115000,
            'description' => 'Kue ulang tahun lucu dengan emoji beruang',
        ]);

        Product::create([
            'category_id' => $milkshake->id,
            'name' => 'Milkshake Strawberry With Boba',
            'code' => 'M-02',
            'stock' => 10,
            'price' => 15000,
            'description' => 'Milkshake strawberry dengan topping boba',
        ]);

        Product::create([
            'category_id' => $minuman->id,
            'name' => 'Air Mineral 600ml',
            'code' => 'M-01',
            'stock' => 100,
            'price' => 5000,
            'description' => 'Air mineral kemasan 600ml',
        ]);

        Product::create([
            'category_id' => $bento->id,
            'name' => 'Roti Chocolate',
            'code' => 'BR-02',
            'stock' => 21,
            'price' => 7000,
            'description' => 'Roti dengan isian cokelat premium',
        ]);

        Product::create([
            'category_id' => $cake->id,
            'name' => 'Matcha Chocholate',
            'code' => 'BC-01',
            'stock' => 3,
            'price' => 100000,
            'description' => 'Cake matcha dengan cokelat',
        ]);
    }
}
