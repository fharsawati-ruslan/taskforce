<?php

namespace App\Imports;

use App\Models\Solution;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SolusiImport implements ToCollection
{
    public function collection(Collection $rows): void
    {
        // ❌ kalau kosong, stop
        if ($rows->isEmpty()) {
            return;
        }

        // 🔥 skip header
        $rows->shift();

        foreach ($rows as $row) {

            // ❌ skip kalau nama kosong
            if (empty($row[0])) {
                continue;
            }

            // 🔥 ambil / buat category otomatis
            $category = Category::firstOrCreate([
                'name' => trim($row[1] ?? 'Uncategorized'),
            ]);

            // ✅ insert data
            Solution::create([
                'name' => trim($row[0]),
                'category_id'   => $category->id,
                'brand'         => trim($row[2] ?? ''),
                'description'   => trim($row[3] ?? ''),
                'price'         => null, // tetap manual
            ]);
        }
    }
}
