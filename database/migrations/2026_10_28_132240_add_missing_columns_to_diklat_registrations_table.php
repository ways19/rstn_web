
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('diklat_registrations', 'access_token')) {
                $table->string('access_token', 64)->nullable()->unique();
            }

            if (!Schema::hasColumn('diklat_registrations', 'study_program')) {
                $table->string('study_program')->nullable();
            }

            if (!Schema::hasColumn('diklat_registrations', 'education_level')) {
                $table->string('education_level')->nullable();
            }

            if (!Schema::hasColumn('diklat_registrations', 'practice_type')) {
                $table->string('practice_type')->nullable();
            }

            if (!Schema::hasColumn('diklat_registrations', 'practice_start_date')) {
                $table->date('practice_start_date')->nullable();
            }

            if (!Schema::hasColumn('diklat_registrations', 'practice_end_date')) {
                $table->date('practice_end_date')->nullable();
            }

            if (!Schema::hasColumn('diklat_registrations', 'profession')) {
                $table->string('profession')->nullable();
            }

            if (!Schema::hasColumn('diklat_registrations', 'position')) {
                $table->string('position')->nullable();
            }

            if (!Schema::hasColumn('diklat_registrations', 'admin_internal_notes')) {
                $table->text('admin_internal_notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            $columns = [
                'access_token',
                'study_program',
                'education_level',
                'practice_type',
                'practice_start_date',
                'practice_end_date',
                'profession',
                'position',
                'admin_internal_notes',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('diklat_registrations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
