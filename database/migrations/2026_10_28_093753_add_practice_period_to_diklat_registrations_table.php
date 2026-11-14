
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            $table->string('study_program')->nullable();
            $table->string('education_level')->nullable();
            $table->string('practice_type')->nullable();
            $table->date('practice_start_date')->nullable();
            $table->date('practice_end_date')->nullable();
            $table->string('profession')->nullable();
            $table->string('position')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'study_program',
                'education_level',
                'practice_type',
                'practice_start_date',
                'practice_end_date',
                'profession',
                'position',
            ]);
        });
    }
};
