<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->unsignedTinyInteger('level')
                ->default(1)
                ->after('page_id');

            $table->foreignId('parent_id')
                ->nullable()
                ->after('level')
                ->constrained('page_sections')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'level']);
        });
    }
};