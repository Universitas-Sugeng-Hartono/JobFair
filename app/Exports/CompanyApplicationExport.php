<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CompanyApplicationExport implements WithMultipleSheets
{
    protected $company;

    public function __construct(Company $company)
    {
        // Load positions so we can iterate over them
        $this->company = $company->load('positions');
    }

    public function sheets(): array
    {
        $sheets = [];

        // Sheet 1: Akses Portal Perusahaan
        $sheets[] = new CompanyPortalAccessSheet($this->company);

        // Sheet 2 onwards: Data Pelamar per Posisi
        foreach ($this->company->positions as $position) {
            $sheets[] = new CompanyApplicantsSheet($this->company, $position);
        }

        return $sheets;
    }
}
