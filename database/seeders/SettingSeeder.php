<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'hero_label', 'value' => 'Informasi Event'],
            ['key' => 'hero_title', 'value' => 'Event Career Terbesar 2026'],
            ['key' => 'hero_subtitle', 'value' => 'Wujudkan Karir Impianmu'],
            ['key' => 'hero_description', 'value' => 'Bergabunglah dengan JobFair 2026 dan temukan peluang karir dari 13+ perusahaan terkemuka di Indonesia. Satu platform, ribuan peluang.'],
            ['key' => 'stat_1_value', 'value' => '13+'],
            ['key' => 'stat_1_label', 'value' => 'Perusahaan'],
            ['key' => 'stat_2_value', 'value' => '250'],
            ['key' => 'stat_2_label', 'value' => 'Kuota Peserta'],
            ['key' => 'stat_3_value', 'value' => '100%'],
            ['key' => 'stat_3_label', 'value' => 'Gratis'],
            ['key' => 'logo_type', 'value' => 'text'], // 'text' atau 'image'
            ['key' => 'logo_text', 'value' => 'JobFair 2026'],
            ['key' => 'logo_image', 'value' => ''],
            ['key' => 'event_date', 'value' => '3 - 10 Juni 2026'],
            ['key' => 'event_date_desc', 'value' => 'Pendaftaran dibuka selama 1 minggu'],
            ['key' => 'event_location', 'value' => 'Online Platform'],
            ['key' => 'event_location_desc', 'value' => 'Akses dari mana saja, kapan saja'],
            ['key' => 'event_info_title', 'value' => 'Informasi Event'],
            ['key' => 'event_quota_title', 'value' => 'Kuota Terbatas'],
            ['key' => 'event_quota_desc', 'value' => 'Hanya 250 peserta yang akan diterima'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
