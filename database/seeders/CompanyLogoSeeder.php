<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Position;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyLogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sourcePath = public_path('logo perusahaan');
        $destinationPath = storage_path('app/public/companies');

        if (!File::exists($sourcePath)) {
            $this->command->error("Source path {$sourcePath} does not exist.");
            return;
        }

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $files = File::files($sourcePath);

        foreach ($files as $index => $file) {
            $filename = $file->getFilename();
            $basename = pathinfo($filename, PATHINFO_FILENAME);
            
            // Generate a pretty company name
            $companyName = str_replace(['-', '_'], ' ', $basename);
            if ($companyName == 'Untitled design 5') $companyName = 'Perusahaan A';
            if ($companyName == 'Untitled design') $companyName = 'Perusahaan B';
            if ($companyName == 'RS Indirati Boyolali') $companyName = 'RS Indriati Boyolali';
            
            // Copy file to storage
            $newFilename = uniqid() . '_' . $filename;
            File::copy($file->getPathname(), $destinationPath . '/' . $newFilename);

            $loginCode = 'COMP-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

            // Create Company
            $company = Company::create([
                'name' => $companyName,
                'description' => 'Perusahaan ' . $companyName . ' yang bergerak di bidang pelayanan dan jasa terbaik di kelasnya.',
                'logo_path' => 'companies/' . $newFilename,
                'login_code' => $loginCode,
                'password' => Hash::make($loginCode),
                'pic_name' => 'Bpk/Ibu ' . explode(' ', $companyName)[0],
            ]);

            // Create 2 Positions for each company
            $positions = [
                ['name' => 'Staff Administrasi', 'job_responsibilities' => 'Mengelola dokumen, pembukuan ringan, dan keperluan administratif kantor.', 'requirements' => "1. Minimal SMA/SMK\n2. Menguasai Ms. Office\n3. Komunikatif"],
                ['name' => 'Marketing Executive', 'job_responsibilities' => 'Mencari klien baru, mempresentasikan produk, dan mencapai target penjualan.', 'requirements' => "1. Minimal D3\n2. Memiliki kendaraan pribadi\n3. Berorientasi pada target"]
            ];

            foreach ($positions as $pos) {
                Position::create([
                    'company_id' => $company->id,
                    'name' => $pos['name'],
                    'selection' => 'Administrasi & Wawancara',
                    'time_to_answer' => 10,
                    'job_responsibilities' => $pos['job_responsibilities'],
                    'requirements' => $pos['requirements'],
                    'location' => 'Penempatan sesuai cabang',
                    'form_config' => [
                        [
                            'label' => 'NIK',
                            'type' => 'text',
                            'required' => true,
                        ],
                        [
                            'label' => 'Nama Lengkap',
                            'type' => 'text',
                            'required' => true,
                        ],
                        [
                            'label' => 'CV / Resume',
                            'type' => 'file',
                            'required' => true,
                        ]
                    ]
                ]);
            }

            $this->command->info("Created company: {$companyName}");
        }
    }
}
