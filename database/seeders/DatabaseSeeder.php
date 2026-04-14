<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🔥 Panggil Seeder
        $this->call([
            CategorySeeder::class,
            IndustrySeeder::class, // kalau sudah ada
        ]);

        // 🔥 Create User (manual / factory)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}