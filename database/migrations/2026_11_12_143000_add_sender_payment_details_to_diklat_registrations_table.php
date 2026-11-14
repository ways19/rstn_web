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
        Schema::table('diklat_registrations', function (Blueprint $table) {
            $table->string('payment_sender_name')->nullable()->after('payment_proof_path');
            $table->string('payment_sender_account_number')->nullable()->after('payment_sender_name');
            $table->string('payment_sender_bank')->nullable()->after('payment_sender_account_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diklat_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'payment_sender_name',
                'payment_sender_account_number',
                'payment_sender_bank',
            ]);
        });
    }
};
