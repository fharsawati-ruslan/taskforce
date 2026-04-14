<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Industry;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CompanyImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 🔥 normalize key (biar aman kalau excel beda format)
        $name = $row['nama_perusahaan'] ?? null;

        // ❌ skip kalau kosong
        if (empty($name)) {
            return null;
        }

        // 🔥 trim biar rapi
        $name = trim($name);

        // ❌ skip duplicate (case insensitive)
        if (Company::whereRaw('LOWER(name) = ?', [Str::lower($name)])->exists()) {
            return null;
        }

        // 🔥 industry fallback
        $industryName = $row['industri'] ?? 'Umum';

        $industry = Industry::firstOrCreate([
            'name' => trim($industryName),
        ]);

        return new Company([
            'name' => $name,
            'industry_id' => $industry->id,

            'customer_name' => $row['customer'] ?? null,
            'pic_name' => $row['pic'] ?? null,
            'pic_position' => $row['jabatan_pic'] ?? null,
            'office_phone' => $row['telepon_kantor'] ?? null,
            'mobile_phone' => $row['no_hp'] ?? null,
            'email' => $row['email'] ?? null,
            'website' => $row['website'] ?? null,
            'address' => $row['alamat'] ?? null,
        ]);
    }
}