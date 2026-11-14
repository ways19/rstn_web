<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppid_objections', function (Blueprint $table) {
            $table->id();

            // Referensi permohonan informasi
            $table->string('ticket_number')->nullable();

            // Identitas pemohon
            $table->string('information_purpose')->nullable();
            $table->string('applicant_name');
            $table->string('applicant_phone');
            $table->text('applicant_address');

            // Identitas wakil/kuasa
            $table->string('representative_name')->nullable();
            $table->string('representative_phone')->nullable();
            $table->text('representative_address')->nullable();

            // Alasan keberatan
            $table->text('objection_reasons')->nullable();

            // Kronologi
            $table->text('objection_chronology')->nullable();

            // Rekaman suara
            $table->string('voice_recording')->nullable();

            // Status proses keberatan
            $table->string('status')->default('diajukan');

            // Catatan admin
            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppid_objections');
    }
};