<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama dulu supaya tidak duplikat
        DB::table('rewards')->truncate();

        $rewards = [
            [
                'name'           => 'Diskon 10% - Short Cake',
                'description'    => 'Dapatkan diskon 10% untuk pembelian Short Cake ukuran apapun.',
                'type'           => 'discount',
                'cost_coins'     => 300,
                'discount_value' => 10.00,
                'image'          => 'reward-images/diskon-short-cake-1.png',
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'name'           => 'Free - Petite Cupcake',
                'description'    => 'Gratis 1 buah Petite Cupcake untuk setiap pembelian.',
                'type'           => 'free_item',
                'cost_coins'     => 300,
                'discount_value' => null,
                'image'          => 'reward-images/free-petite-cupcake-1.png',
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'name'           => 'Free - Bento Cake',
                'description'    => 'Gratis 1 Bento Cake spesial pilihan.',
                'type'           => 'free_item',
                'cost_coins'     => 800,
                'discount_value' => null,
                'image'          => 'reward-images/free-bento-cake-1.png',
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'name'           => 'Diskon 10% - Short Cake',
                'description'    => 'Tukar koin kamu dengan diskon 10% Short Cake.',
                'type'           => 'discount',
                'cost_coins'     => 300,
                'discount_value' => 10.00,
                'image'          => 'reward-images/diskon-short-cake-2.png',
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'name'           => 'Free - Bento Cake',
                'description'    => 'Gratis Bento Cake untuk pesanan berikutnya.',
                'type'           => 'free_item',
                'cost_coins'     => 800,
                'discount_value' => null,
                'image'          => 'reward-images/free-bento-cake-2.png',
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'name'           => 'Diskon 10% - Short Cake',
                'description'    => 'Diskon spesial 10% untuk Short Cake.',
                'type'           => 'discount',
                'cost_coins'     => 300,
                'discount_value' => 10.00,
                'image'          => 'reward-images/diskon-short-cake-3.png',
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'name'           => 'Free - Petite Cupcake',
                'description'    => 'Gratis Petite Cupcake mini untuk kamu.',
                'type'           => 'free_item',
                'cost_coins'     => 300,
                'discount_value' => null,
                'image'          => 'reward-images/free-petite-cupcake-2.png',
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ];

        DB::table('rewards')->insert($rewards);
    }
}