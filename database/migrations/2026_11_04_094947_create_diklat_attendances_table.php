
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diklat_attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('diklat_program_id')
                ->constrained('diklat_programs')
                ->restrictOnDelete();

            $table->string('full_name');
            $table->string('institution');

            // Identitas ternormalisasi untuk mencegah absensi ganda
            $table->string('identity_key', 64);

            $table->dateTime('attended_at');

            $table->timestamps();

            // Satu identitas hanya boleh absen sekali per program
            $table->unique(
                ['diklat_program_id', 'identity_key'],
                'diklat_attendance_unique_participant'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diklat_attendances');
    }
};
