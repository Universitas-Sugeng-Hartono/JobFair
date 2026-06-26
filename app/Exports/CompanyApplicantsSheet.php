<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\Position;
use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CompanyApplicantsSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $company;
    protected $position;
    protected $dynamicFieldLabels = [];
    protected $rowNumber = 0;
    protected $productionUrl;
    protected $sectionColumns = [];

    public function __construct(Company $company, Position $position)
    {
        $this->company = $company;
        $this->position = $position;
        $this->productionUrl = \App\Models\Setting::where('key', 'production_url')->value('value');
        
        $formConfig = $this->position->form_config ?? [];
        $colIndex = 6; // Data starts at column F (which is index 6: A=1, B=2, C=3, D=4, E=5)
        
        foreach ($formConfig as $field) {
            $labelLower = strtolower(trim($field['label']));
            if (!in_array($labelLower, ['nik', 'nama', 'nama lengkap', 'nama peserta'])) {
                if (!in_array($field['label'], $this->dynamicFieldLabels)) {
                    $this->dynamicFieldLabels[] = $field['label'];
                    if (isset($field['type']) && $field['type'] === 'step') {
                        $this->sectionColumns[] = $colIndex;
                    }
                    $colIndex++;
                }
            }
        }
    }

    public function collection()
    {
        return Application::with(['participant', 'position'])
            ->whereHas('participant', function ($query) {
                $query->whereNotNull('attended_at');
            })
            ->where('position_id', $this->position->id)
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
            "'" . $application->participant->nik,
            $application->participant->name ?? '-',
            $application->position->name ?? '-',
            $application->created_at->format('d/m/Y H:i:s'),
        ];

        // Map answers by label from answers_payload
        $answersByLabel = [];
        $payload = $application->answers_payload ?? [];
        foreach ($payload as $answer) {
            if (isset($answer['label'])) {
                $answersByLabel[$answer['label']] = $answer;
            }
        }

        $colIndex = 6;
        foreach ($this->dynamicFieldLabels as $label) {
            if (in_array($colIndex, $this->sectionColumns)) {
                $row[] = ''; // Keep it blank for data rows
            } elseif (isset($answersByLabel[$label])) {
                $ans = $answersByLabel[$label];
                if (isset($ans['type']) && $ans['type'] === 'file' && !empty($ans['path'])) {
                    // if there are multiple files, just use the first or join URLs. Let's join URLs with comma.
                    $paths = explode(',', $ans['path']);
                    $urls = [];
                    foreach($paths as $path) {
                        if ($this->productionUrl) {
                            $baseUrl = rtrim($this->productionUrl, '/');
                            $urls[] = $baseUrl . '/storage/' . trim($path);
                        } else {
                            $urls[] = asset('storage/' . trim($path));
                        }
                    }
                    $row[] = implode(', ', $urls);
                } else {
                    $row[] = $ans['value'] ?? '-';
                }
            } else {
                $row[] = '-';
            }
            $colIndex++;
        }

        return $row;
    }

    public function title(): string
    {
        // Excel sheet names max 31 chars and no special chars like: * : ? / \ [ ]
        $title = preg_replace('/[\*\:\?\/\\\[\]]/', '', $this->position->name);
        return substr($title, 0, 31);
    }

    public function styles(Worksheet $sheet)
    {
        $styles = [
            1    => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2563EB'] 
                ]
            ],
        ];

        // Colorize section headers differently
        foreach ($this->sectionColumns as $colIndex) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
            $styles[$columnLetter . '1'] = [
                'font' => ['bold' => true, 'color' => ['argb' => 'FF000000']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFACC15'] // Yellow for section headers
                ]
            ];
        }

        return $styles;
    }
}
