<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('cta_text')->nullable();
            $table->string('cta_link')->nullable();
            $table->string('cta_text2')->nullable();
            $table->string('cta_link2')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('rawat-jalan'); // darurat, rawat-jalan, rawat-inap, unggulan, penunjang
            $table->string('tag')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->json('facilities')->nullable();
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('speciality');
            $table->string('sub_speciality')->nullable();
            $table->string('poli');
            $table->string('schedule');
            $table->json('days')->nullable();
            $table->string('experience')->nullable();
            $table->string('education')->nullable();
            $table->string('photo')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Berita'); // Berita, Pengumuman, Edukasi, Artikel
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->date('published_at')->nullable();
            $table->integer('views')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('beds', function (Blueprint $table) {
            $table->id();
            $table->string('class_name');
            $table->integer('total')->default(0);
            $table->integer('available')->default(0);
            $table->integer('occupied')->default(0);
            $table->string('gender_room')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('queue_number')->unique();
            $table->string('patient_type')->default('lama'); // lama / baru
            $table->string('nik', 20);
            $table->string('rm_number', 20)->nullable();
            $table->string('patient_name');
            $table->string('phone', 25);
            $table->string('insurance')->default('bpjs'); // bpjs, umum, asuransi
            $table->string('clinic');
            $table->string('doctor_name')->nullable();
            $table->date('visit_date');
            $table->string('status')->default('terdaftar'); // terdaftar, dipanggil, selesai, batal
            $table->timestamps();
        });

        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('category')->default('Saran');
            $table->text('message');
            $table->string('status')->default('baru'); // baru, diproses, selesai
            $table->text('reply')->nullable();
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('PPID'); // PPID, Standar Pelayanan, Profil, Regulasi
            $table->longText('content')->nullable();
            $table->string('file_attachment')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('beds');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('services');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('settings');
    }
};