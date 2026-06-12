<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('login_code')->unique()->nullable()->after('description');
            $table->string('password')->nullable()->after('login_code');
            $table->string('email')->nullable()->after('password');
            $table->string('pic_name')->nullable()->after('email'); // Person in charge
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['login_code', 'password', 'email', 'pic_name']);
        });
    }
};
