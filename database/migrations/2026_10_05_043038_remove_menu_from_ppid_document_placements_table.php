<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppid_document_placements', function (Blueprint $table) {
            $table->dropUnique([
                'ppid_document_id',
                'menu',
                'page_section_id',
            ]);

            $table->dropColumn('menu');

            $table->unique([
                'ppid_document_id',
                'page_section_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('ppid_document_placements', function (Blueprint $table) {
            $table->string('menu')->after('ppid_document_id');

            $table->dropUnique([
                'ppid_document_id',
                'page_section_id',
            ]);

            $table->unique([
                'ppid_document_id',
                'menu',
                'page_section_id',
            ]);
        });
    }
};