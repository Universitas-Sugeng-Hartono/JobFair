<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CompanyApplicationExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $company;
    protected $dynamicFieldLabels = [];
    protected $rowNumber = 0;
    protected $productionUrl;

    public function __construct(Company $company)
    {
        $this->company = $company;
        $this->productionUrl = \App\Models\Setting::where('key', 'production_url')->value('value');
        
        foreach ($company->positions as $pos) {
            $formConfig = $pos->form_config ?? [];
            foreach ($formConfig as $field) {
                $labelLower = strtolower(trim($field['label']));
                if (!in_array($labelLower, ['nik', 'nama', 'nama lengkap', 'nama peserta'])) {
                    if (!in_array($field['label'], $this->dynamicFieldLabels)) {
                        $this->dynamicFieldLabels[] = $field['label'];
                    }
                }
            }
        }
    }

    public function collection()
    {
        $positionIds = $this->company->positions->pluck('id')->toArray();
        return Application::with(['participant', 'answers', 'position'])
            ->whereHas('participant', function ($query) {
                $query->whereNotNull('attended_at');
            })
            ->whereIn('position_id', $positionIds)
            ->oldest()
            ->get();
    }

    public function headings(): array
    {
        $headers = [
            'No',
            'NIK',
            'Nama Lengkap',
            'Posisi Dilamar',
            'Waktu Melamar'
        ];

        return array_merge($headers, $this->dynamicFieldLabels);
    }

    public function map($application): array
    {
        $this->rowNumber++;

        $row = [
            $this->rowNumber,
            $application->participant->nik,
            $application->participant->name ?? '-',
            $application->position->name ?? '-',
            $application->created_at->format('d/m/Y H:i:s'),
        ];

        // Map answers by label
        $answersByLabel = [];
        foreach ($application->answers as $answer) {
            $answersByLabel[$answer->field_label] = $answer;
        }

        foreach ($this->dynamicFieldLabels as $label) {
            if (isset($answersByLabel[$label])) {
                $ans = $answersByLabel[$label];
                if ($ans->field_type === 'file' && $ans->file_path) {
                    if ($this->productionUrl) {
                        $baseUrl = rtrim($this->productionUrl, '/');
                        $row[] = $baseUrl . '/storage/' . $ans->file_path;
                    } else {
                        $row[] = asset('storage/' . $ans->file_path);
                    }
                } else {
                    $row[] = $ans->field_value ?? '-';
                }
            } else {
                $row[] = '-';
            }
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            
            1    => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2563EB'] 
                ]
            ],
        ];
    }
}
