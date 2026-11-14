<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppid_information_requests', function (Blueprint $table) {
            $table->id();

            // Nomor tiket
            $table->string('ticket_number')->unique();

            // Identitas pemohon
            $table->string('applicant_category')->nullable();
            $table->string('nik')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            // Dokumen identitas
            $table->string('identity_file')->nullable();

            // Rincian permohonan
            $table->text('information_detail');
            $table->text('purpose')->nullable();

            // Cara memperoleh informasi
            $table->string('obtaining_method')->nullable();

            // Cara menerima informasi
            $table->string('delivery_method')->nullable();

            // Status permohonan
            $table->string('status')->default('diajukan');

            // Catatan dari PPID
            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppid_information_requests');
    }
};