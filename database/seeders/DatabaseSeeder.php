<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Buat akun Admin
        User::factory()->create([
            'name'     => 'Admin JobFair',
            'email'    => 'admin@jobfair.com',
            'password' => bcrypt('password'),
        ]);

        $defaultForm = [
            ['id' => '1', 'type' => 'text',   'label' => 'Nama Lengkap',           'required' => true],
            ['id' => '2', 'type' => 'number', 'label' => 'NIK',                    'required' => true],
            ['id' => '3', 'type' => 'file',   'label' => 'Upload CV/Lamaran',      'required' => true],
            ['id' => '4', 'type' => 'file',   'label' => 'Upload KTP',             'required' => true],
            ['id' => '5', 'type' => 'text',   'label' => 'Nomor HP / WhatsApp',    'required' => true],
        ];

        $companies = [
            [
                'name'        => 'PT Duniatex',
                'logo'        => 'companies/Duniatex.png',
                'description' => 'Duniatex Group adalah perusahaan tekstil terpadu terbesar di Asia Tenggara yang bergerak di bidang pemintalan benang, penenunan kain, hingga pencelupan dan finishing.',
                'positions'   => [
                    ['name' => 'Operator Produksi',  'selection' => 'Interview HR', 'time_to_answer' => '3 Hari Kerja', 'requirements' => 'Min. SMA/SMK sederajat, bersedia kerja shift.'],
                    ['name' => 'Staff Administrasi', 'selection' => 'Interview HR, Psikotes', 'time_to_answer' => '5 Hari Kerja', 'requirements' => 'Min. D3 semua jurusan, mahir MS Office.'],
                ],
            ],
            [
                'name'        => 'Fave Hotel Manahan Solo',
                'logo'        => 'companies/Fave-Hotel-Manahan-Solo.png',
                'description' => 'Fave Hotel Manahan Solo adalah hotel budget bintang 2 yang berlokasi strategis di kawasan Manahan, Solo, menawarkan kenyamanan dengan harga terjangkau.',
                'positions'   => [
                    ['name' => 'Front Desk Agent',  'selection' => 'Interview HR & User', 'time_to_answer' => '3 Hari Kerja', 'requirements' => 'Min. D3 Perhotelan, komunikatif, bisa bahasa Inggris.'],
                    ['name' => 'Housekeeping Staff', 'selection' => 'Interview HR', 'time_to_answer' => '2 Hari Kerja', 'requirements' => 'Min. SMA/SMK, pengalaman diutamakan, teliti dan rapi.'],
                ],
            ],
            [
                'name'        => 'Fave Hotel Solo Baru',
                'logo'        => 'companies/Fave-Hotel-Solo-Baru.png',
                'description' => 'Fave Hotel Solo Baru merupakan hotel modern yang berada di kawasan Solo Baru, menyediakan layanan akomodasi berkualitas untuk wisatawan dan pebisnis.',
                'positions'   => [
                    ['name' => 'Guest Service Agent', 'selection' => 'Interview HR & User', 'time_to_answer' => '4 Hari Kerja', 'requirements' => 'Min. D3 Perhotelan/Pariwisata, ramah dan proaktif.'],
                ],
            ],
            [
                'name'        => 'Grand Mercure Solo Baru',
                'logo'        => 'companies/Grand-Mercure.png',
                'description' => 'Grand Mercure adalah hotel bintang 5 internasional bagian dari jaringan AccorHotels, menawarkan fasilitas mewah dan layanan premium di Solo Baru.',
                'positions'   => [
                    ['name' => 'F&B Service Staff',  'selection' => 'Interview HR & GM', 'time_to_answer' => '7 Hari Kerja', 'requirements' => 'D3/S1 Perhotelan, pengalaman min. 1 tahun di hotel bintang 4/5.'],
                    ['name' => 'Sales Executive',     'selection' => 'Interview HR & User, Presentasi', 'time_to_answer' => '7 Hari Kerja', 'requirements' => 'S1 semua jurusan, target-oriented, berpengalaman di bidang penjualan hotel.'],
                    ['name' => 'Engineering Staff',  'selection' => 'Interview HR & User', 'time_to_answer' => '5 Hari Kerja', 'requirements' => 'D3 Teknik Elektro/Mesin, berpengalaman di bidang maintenance gedung.'],
                ],
            ],
            [
                'name'        => 'Hartono Trade Center (HTC)',
                'logo'        => 'companies/Hartono-Trade-Center.png',
                'description' => 'Hartono Trade Center adalah pusat perbelanjaan modern yang menjadi salah satu pusat perdagangan elektronik dan fashion terkemuka di Solo.',
                'positions'   => [
                    ['name' => 'Pramuniaga / SPG-SPB', 'selection' => 'Interview HR', 'time_to_answer' => '3 Hari Kerja', 'requirements' => 'Min. SMA/SMK, berpenampilan menarik, komunikatif.'],
                    ['name' => 'Security Officer',       'selection' => 'Interview HR & Psikotes', 'time_to_answer' => '5 Hari Kerja', 'requirements' => 'Min. SMA/SMK, tinggi badan min. 165 cm, sehat jasmani rohani.'],
                ],
            ],
            [
                'name'        => 'Noorman Semarang',
                'logo'        => 'companies/Noorman-Semarang.png',
                'description' => 'Noorman Semarang adalah perusahaan yang bergerak di bidang retail fashion dan lifestyle, menyediakan berbagai produk branded lokal dan internasional.',
                'positions'   => [
                    ['name' => 'Store Supervisor',  'selection' => 'Interview HR & User', 'time_to_answer' => '5 Hari Kerja', 'requirements' => 'Min. D3, pengalaman min. 2 tahun di retail, leadership skill.'],
                    ['name' => 'Kasir',              'selection' => 'Interview HR', 'time_to_answer' => '3 Hari Kerja', 'requirements' => 'Min. SMA/SMK, teliti, jujur, dan bisa bekerja dalam tim.'],
                ],
            ],
            [
                'name'        => 'Pion Bihun Jagung',
                'logo'        => 'companies/Pion-Bihun-Jagung.png',
                'description' => 'Pion Bihun Jagung adalah produsen bihun jagung premium yang mengutamakan bahan baku alami dan proses produksi higienis untuk menghasilkan produk pangan berkualitas tinggi.',
                'positions'   => [
                    ['name' => 'Operator Mesin Produksi', 'selection' => 'Interview HR', 'time_to_answer' => '3 Hari Kerja', 'requirements' => 'Min. SMA/SMK Industri, bersedia kerja shift, berpengalaman diutamakan.'],
                    ['name' => 'Quality Control (QC)',     'selection' => 'Interview HR & User', 'time_to_answer' => '5 Hari Kerja', 'requirements' => 'D3/S1 Teknologi Pangan, teliti, dan memahami standar HACCP.'],
                    ['name' => 'Staff Gudang (Logistik)',  'selection' => 'Interview HR', 'time_to_answer' => '3 Hari Kerja', 'requirements' => 'Min. SMA/SMK, bisa mengoperasikan forklift (diutamakan), fisik prima.'],
                ],
            ],
            [
                'name'        => 'RS Indriati Boyolali',
                'logo'        => 'companies/RS-Indirati-Boyolali.png',
                'description' => 'Rumah Sakit Indriati Boyolali adalah rumah sakit swasta modern yang memberikan pelayanan kesehatan komprehensif untuk masyarakat Boyolali dan sekitarnya.',
                'positions'   => [
                    ['name' => 'Perawat (Nurse)',           'selection' => 'Interview HR & Direktur Keperawatan, Uji Kompetensi', 'time_to_answer' => '7 Hari Kerja', 'requirements' => 'D3/S1 Keperawatan, STR aktif, pengalaman min. 1 tahun.'],
                    ['name' => 'Bidan',                     'selection' => 'Interview HR & User', 'time_to_answer' => '7 Hari Kerja', 'requirements' => 'D3/D4 Kebidanan, STR aktif.'],
                    ['name' => 'Radiografer',               'selection' => 'Interview HR & User', 'time_to_answer' => '7 Hari Kerja', 'requirements' => 'D3/D4 Radiodiagnostik, STR aktif.'],
                    ['name' => 'Staf Administrasi RS',      'selection' => 'Interview HR & Psikotes', 'time_to_answer' => '5 Hari Kerja', 'requirements' => 'Min. D3 semua jurusan, mahir komputer, komunikatif.'],
                ],
            ],
            [
                'name'        => 'RS Indriati Solo Baru',
                'logo'        => 'companies/RS-Indriati-Solo-Baru.png',
                'description' => 'Rumah Sakit Indriati Solo Baru adalah rumah sakit tipe C yang berlokasi di Solo Baru, menyediakan layanan rawat inap, rawat jalan, dan unit gawat darurat 24 jam.',
                'positions'   => [
                    ['name' => 'Dokter Umum (Jaga)',       'selection' => 'Interview Direktur Medis', 'time_to_answer' => '7 Hari Kerja', 'requirements' => 'Profesi Dokter, STR & SIP aktif, bersedia jaga shift.'],
                    ['name' => 'Perawat (Nurse)',           'selection' => 'Interview HR & Direktur Keperawatan, Uji Kompetensi', 'time_to_answer' => '7 Hari Kerja', 'requirements' => 'D3/S1 Keperawatan, STR aktif.'],
                    ['name' => 'Analis Laboratorium',      'selection' => 'Interview HR & User', 'time_to_answer' => '7 Hari Kerja', 'requirements' => 'D3/D4 Analis Kesehatan, STR aktif, teliti.'],
                ],
            ],
            [
                'name'        => 'Swiss-Belhotel Solo',
                'logo'        => 'companies/Swiss-belhotel.png',
                'description' => 'Swiss-Belhotel adalah jaringan hotel internasional asal Hong Kong yang menawarkan akomodasi bintang 4 dengan standar pelayanan global di pusat Kota Solo.',
                'positions'   => [
                    ['name' => 'Front Office Staff',    'selection' => 'Interview HR & FOM', 'time_to_answer' => '5 Hari Kerja', 'requirements' => 'D3 Perhotelan, bisa bahasa Inggris, berpenampilan profesional.'],
                    ['name' => 'Restaurant Captain',    'selection' => 'Interview HR & F&B Manager', 'time_to_answer' => '5 Hari Kerja', 'requirements' => 'Min. D3 Perhotelan, pengalaman min. 2 tahun, leadership skill.'],
                ],
            ],
            [
                'name'        => 'The Alana Hotel & Conference Center',
                'logo'        => 'companies/The-Alana.png',
                'description' => 'The Alana Hotel adalah hotel bintang 4 yang terkenal dengan fasilitas MICE (Meeting, Incentive, Convention & Exhibition) terlengkap di Solo, Jawa Tengah.',
                'positions'   => [
                    ['name' => 'Event Coordinator',      'selection' => 'Interview HR & GM, Presentasi', 'time_to_answer' => '7 Hari Kerja', 'requirements' => 'S1 Pariwisata/Komunikasi, berpengalaman di bidang event min. 1 tahun.'],
                    ['name' => 'Banquet Staff',           'selection' => 'Interview HR & User', 'time_to_answer' => '3 Hari Kerja', 'requirements' => 'Min. SMA/SMK, siap kerja event weekends, penampilan rapi.'],
                    ['name' => 'Marketing Executive',    'selection' => 'Interview HR & GM', 'time_to_answer' => '7 Hari Kerja', 'requirements' => 'S1 semua jurusan, komunikatif, target-oriented, berpengalaman di hospitality.'],
                ],
            ],
        ];

        foreach ($companies as $companyData) {
            $company = \App\Models\Company::create([
                'name'        => $companyData['name'],
                'logo_path'   => $companyData['logo'],
                'description' => $companyData['description'],
            ]);

            foreach ($companyData['positions'] as $i => $posData) {
                \App\Models\Position::create([
                    'company_id'          => $company->id,
                    'name'                => $posData['name'],
                    'selection'           => $posData['selection'],
                    'time_to_answer'      => $posData['time_to_answer'],
                    'job_responsibilities' => 'Melaksanakan tugas dan tanggung jawab sesuai posisi ' . $posData['name'] . ' di ' . $companyData['name'] . '.',
                    'requirements'        => $posData['requirements'],
                    'form_config'         => $defaultForm,
                ]);
            }
        }
    }
}
