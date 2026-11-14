<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('diklat_documentations') && !Schema::hasColumn('diklat_documentations', 'is_active')) {
            Schema::table('diklat_documentations', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('description');
            });
        }

        if (Schema::hasTable('accreditation_certificates') && !Schema::hasColumn('accreditation_certificates', 'is_active')) {
            Schema::table('accreditation_certificates', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('description');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('diklat_documentations') && Schema::hasColumn('diklat_documentations', 'is_active')) {
            Schema::table('diklat_documentations', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }

        if (Schema::hasTable('accreditation_certificates') && Schema::hasColumn('accreditation_certificates', 'is_active')) {
            Schema::table('accreditation_certificates', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
};
