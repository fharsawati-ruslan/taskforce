<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Industry;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industries = [
            'Pemerintah',
            'BUMN',
            'Perbankan',
            'Keuangan',
            'Asuransi',
            'Telekomunikasi',
            'Teknologi Informasi',
            'Manufaktur',
            'Otomotif',
            'Konstruksi',
            'Properti',
            'Retail',
            'Logistik',
            'Transportasi',
            'Energi',
            'Pertambangan',
            'Minyak & Gas',
            'Kesehatan',
            'Pendidikan',
            'Hospitality',
            'FMCG',
            'Startup',
            'UMKM',
        ];

        foreach ($industries as $industry) {
            Industry::firstOrCreate([
                'name' => $industry,
            ]);
        }
    }
}