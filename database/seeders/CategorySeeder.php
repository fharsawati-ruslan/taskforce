<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Network & Infrastructure'],
            ['name' => 'Cybersecurity'],
            ['name' => 'Application & Software'],
            ['name' => 'Digital & IoT'],
            ['name' => 'Data Center & Storage'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}