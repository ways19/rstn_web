<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diklat_programs', function (Blueprint $table) {
            if (! Schema::hasColumn('diklat_programs', 'payment_bank_name')) {
                $table->string('payment_bank_name')->nullable();
            }
            if (! Schema::hasColumn('diklat_programs', 'payment_account_number')) {
                $table->string('payment_account_number', 50)->nullable();
            }
            if (! Schema::hasColumn('diklat_programs', 'payment_account_name')) {
                $table->string('payment_account_name')->nullable();
            }
        });

        Schema::table('diklat_registrations', function (Blueprint $table) {
            if (! Schema::hasColumn('diklat_registrations', 'payment_proof_path')) {
                $table->string('payment_proof_path')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('diklat_programs', function (Blueprint $table) {
            $table->dropColumn(['payment_bank_name', 'payment_account_number', 'payment_account_name']);
        });

        Schema::table('diklat_registrations', function (Blueprint $table) {
            $table->dropColumn('payment_proof_path');
        });
    }
};
