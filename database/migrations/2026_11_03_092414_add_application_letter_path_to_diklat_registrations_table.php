<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            $table->string('application_letter_path')
                ->nullable()
                ->after('purpose');
        });
    }

    public function down(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            $table->dropColumn('application_letter_path');
        });
    }
};