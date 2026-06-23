<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->json('answers_payload')->nullable()->after('status');
        });

        // Pindahkan data lama dari application_answers ke applications.answers_payload
        $applications = DB::table('applications')->get();
        foreach ($applications as $app) {
            $answers = DB::table('application_answers')->where('application_id', $app->id)->get();
            if ($answers->count() > 0) {
                $payload = [];
                foreach ($answers as $ans) {
                    $payload[] = [
                        'label' => $ans->field_label,
                        'type'  => $ans->field_type,
                        'value' => $ans->field_value,
                        'path'  => $ans->file_path,
                    ];
                }
                DB::table('applications')->where('id', $app->id)->update([
                    'answers_payload' => json_encode($payload)
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('answers_payload');
        });
    }
};
