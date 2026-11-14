<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppid_information_requests', function (Blueprint $table) {
            $table->text('information_detail')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ppid_information_requests', function (Blueprint $table) {
            $table->text('information_detail')->nullable(false)->change();
        });
    }
};