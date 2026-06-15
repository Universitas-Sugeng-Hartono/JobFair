<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Participant;
use App\Models\Position;
use App\Models\Application;
use App\Models\ApplicationAnswer;
use Faker\Factory as Faker;

class ParticipantApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $positions = Position::all();

        if ($positions->isEmpty()) {
            $this->command->error('No positions found. Please run CompanyLogoSeeder first.');
            return;
        }

        $this->command->info('Generating 250 participants and their applications...');

        for ($i = 0; $i < 250; $i++) {
            // Generate 16-digit NIK
            $nik = $faker->numerify('################');
            
            // Create Participant
            $participant = Participant::create([
                'nik' => $nik,
                'name' => $faker->name,
                // Randomly assign some attendance
                'attended_at' => $faker->boolean(60) ? $faker->dateTimeBetween('-1 days', 'now') : null,
            ]);

            // Pick 1 to 3 random positions
            $appliedPositions = $positions->random(rand(1, 3));

            foreach ($appliedPositions as $pos) {
                // Status can be submitted, accepted, rejected
                $statuses = ['submitted', 'accepted', 'rejected'];
                $status = $faker->randomElement($statuses);

                $application = Application::create([
                    'participant_id' => $participant->id,
                    'position_id' => $pos->id,
                    'status' => $status,
                    'accepted_at' => $status === 'accepted' ? $faker->dateTimeBetween('-1 days', 'now') : null,
                ]);

                // Create Answers based on position form_config
                if ($pos->form_config) {
                    foreach ($pos->form_config as $field) {
                        $answer = new ApplicationAnswer([
                            'application_id' => $application->id,
                            'field_label' => $field['label'],
                            'field_type' => $field['type'],
                        ]);

                        $labelLower = strtolower($field['label']);

                        if ($field['type'] === 'file') {
                            $answer->file_path = 'dummy/cv_' . $nik . '.pdf';
                        } else {
                            if (str_contains($labelLower, 'nik')) {
                                $answer->field_value = $nik;
                            } elseif (str_contains($labelLower, 'nama')) {
                                $answer->field_value = $participant->name;
                            } elseif (str_contains($labelLower, 'email')) {
                                $answer->field_value = $faker->email;
                            } elseif (str_contains($labelLower, 'telp') || str_contains($labelLower, 'hp')) {
                                $answer->field_value = $faker->phoneNumber;
                            } else {
                                $answer->field_value = $faker->sentence(3);
                            }
                        }

                        $answer->save();
                    }
                }
            }
        }

        $this->command->info('Successfully generated 250 participants with applications!');
    }
}
