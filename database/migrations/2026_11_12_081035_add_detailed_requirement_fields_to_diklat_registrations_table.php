<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            // Berkas Tambahan Pendidikan & Mahasiswa
            $table->string('participant_list_path')->nullable()->after('application_letter_path');
            $table->string('insurance_proof_path')->nullable()->after('participant_list_path');
            $table->string('id_photo_path')->nullable()->after('insurance_proof_path');

            // Berkas & Data Tambahan Pelatihan Medis / Nakes
            $table->string('str_number')->nullable()->after('position');
            $table->string('str_file_path')->nullable()->after('str_number');
            $table->string('satusehat_id')->nullable()->after('str_file_path');
            $table->string('assignment_letter_path')->nullable()->after('satusehat_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'participant_list_path',
                'insurance_proof_path',
                'id_photo_path',
                'str_number',
                'str_file_path',
                'satusehat_id',
                'assignment_letter_path',
            ]);
        });
    }
};
