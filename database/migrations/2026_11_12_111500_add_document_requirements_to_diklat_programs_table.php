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
        Schema::table('diklat_programs', function (Blueprint $table) {
            $table->boolean('requires_assignment_letter')->default(true)->after('requires_registration');
            $table->boolean('requires_str_file')->default(false)->after('requires_assignment_letter');
            $table->boolean('requires_id_photo')->default(false)->after('requires_str_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diklat_programs', function (Blueprint $table) {
            $table->dropColumn([
                'requires_assignment_letter',
                'requires_str_file',
                'requires_id_photo',
            ]);
        });
    }
};
