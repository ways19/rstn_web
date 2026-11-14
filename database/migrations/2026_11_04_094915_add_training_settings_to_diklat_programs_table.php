
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diklat_programs', function (Blueprint $table) {
            // Kolom informasi program yang belum tersedia
            $table->string('organizer')->nullable();
            $table->string('method')->nullable();
            $table->string('location')->nullable();

            // Pengaturan pendaftaran
            $table->boolean('requires_registration')->default(true);

            // Pengaturan biaya
            $table->boolean('is_paid')->default(false);
            $table->unsignedBigInteger('fee')->nullable();

            // Sasaran peserta
            $table->string('participant_target')
                ->default('publik');

            // Jadwal pelatihan
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('diklat_programs', function (Blueprint $table) {
            $table->dropColumn([
                'organizer',
                'method',
                'location',
                'requires_registration',
                'is_paid',
                'fee',
                'participant_target',
                'start_at',
                'end_at',
            ]);
        });
    }
};
