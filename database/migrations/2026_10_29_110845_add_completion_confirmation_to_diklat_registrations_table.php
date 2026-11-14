<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            $table->timestamp('completion_confirmed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            $table->dropColumn('completion_confirmed_at');
        });
    }
};
