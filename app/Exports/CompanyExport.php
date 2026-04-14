<?PHP
namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompanyExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Company::with('industry')->get()->map(function ($item) {
            return [
                'Nama Perusahaan' => $item->name,
                'Industri' => $item->industry?->name,
                'Customer' => $item->customer_name,
                'PIC' => $item->pic_name,
                'Jabatan PIC' => $item->pic_position,
                'Telepon Kantor' => $item->office_phone,
                'No HP' => $item->mobile_phone,
                'Email' => $item->email,
                'Website' => $item->website,
                'Alamat' => $item->address,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Perusahaan',
            'Industri',
            'Customer',
            'PIC',
            'Jabatan PIC',
            'Telepon Kantor',
            'No HP',
            'Email',
            'Website',
            'Alamat',
        ];
    }
}