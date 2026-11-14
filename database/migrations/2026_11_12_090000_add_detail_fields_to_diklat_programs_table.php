<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diklat_programs', function (Blueprint $table) {
            if (! Schema::hasColumn('diklat_programs', 'objectives')) {
                $table->text('objectives')->nullable()->after('description');
            }
            if (! Schema::hasColumn('diklat_programs', 'materials')) {
                $table->text('materials')->nullable()->after('objectives');
            }
            if (! Schema::hasColumn('diklat_programs', 'requirements')) {
                $table->text('requirements')->nullable()->after('materials');
            }
            if (! Schema::hasColumn('diklat_programs', 'facilities')) {
                $table->text('facilities')->nullable()->after('requirements');
            }
            if (! Schema::hasColumn('diklat_programs', 'skp_points')) {
                $table->string('skp_points', 100)->nullable()->after('facilities');
            }
            if (! Schema::hasColumn('diklat_programs', 'contact_person')) {
                $table->string('contact_person', 255)->nullable()->after('skp_points');
            }
            if (! Schema::hasColumn('diklat_programs', 'flyer_image')) {
                $table->string('flyer_image', 255)->nullable()->after('contact_person');
            }
        });
    }

    public function down(): void
    {
        Schema::table('diklat_programs', function (Blueprint $table) {
            $table->dropColumn([
                'objectives',
                'materials',
                'requirements',
                'facilities',
                'skp_points',
                'contact_person',
                'flyer_image',
            ]);
        });
    }
};
