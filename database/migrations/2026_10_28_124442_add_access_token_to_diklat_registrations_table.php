<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            $table->string('access_token', 64)
                ->nullable()
                ->unique()
                ->after('registration_number');
        });
    }

    public function down(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            $table->dropUnique(['access_token']);
            $table->dropColumn('access_token');
        });
    }
};