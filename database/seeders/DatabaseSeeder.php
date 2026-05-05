<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    public function run(): void
{
    User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    // Fix kode produk PRD
    $fixes = [
        'PRD-001' => 'CK-006',
        'PRD-002' => 'CK-007',
        'PRD-003' => 'CK-008',
        'PRD-004' => 'BN-002',
        'PRD-005' => 'CK-009',
        'PRD-006' => 'ML-003',
        'PRD-007' => 'ML-004',
        'PRD-008' => 'CC-002',
    ];

    foreach ($fixes as $oldCode => $newCode) {
        \App\Models\Product::where('code', $oldCode)->update(['code' => $newCode]);
    }
}
}
