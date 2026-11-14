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
        Schema::table('pages', function (Blueprint $table) {
            $table->string('section_1_title')->nullable()->after('description');
            $table->text('section_1_description')->nullable()->after('section_1_title');

            $table->string('section_2_title')->nullable()->after('section_1_description');
            $table->text('section_2_description')->nullable()->after('section_2_title');

            $table->string('section_3_title')->nullable()->after('section_2_description');
            $table->text('section_3_description')->nullable()->after('section_3_title');

            $table->string('note_title')->nullable()->after('section_3_description');
            $table->text('note_content')->nullable()->after('note_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'section_1_title',
                'section_1_description',
                'section_2_title',
                'section_2_description',
                'section_3_title',
                'section_3_description',
                'note_title',
                'note_content',
            ]);
        });
    }
};
