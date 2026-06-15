<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CompanyPortalAccessSheet implements FromArray, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function array(): array
    {
        return [
            [
                $this->company->name,
                $this->company->login_code,
                $this->company->login_code,
                url('/perusahaan/login')
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Perusahaan',
            'Kode Login',
            'Password',
            'Link Login'
        ];
    }

    public function title(): string
    {
        return 'Akses Portal Perusahaan';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2563EB'] 
                ]
            ],
        ];
    }
}
