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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('section_1_title')->nullable();
            $table->text('section_1_description')->nullable();

            $table->string('section_2_title')->nullable();
            $table->text('section_2_description')->nullable();

            $table->string('section_3_title')->nullable();
            $table->text('section_3_description')->nullable();

            $table->string('note_title')->nullable();
            $table->text('note_content')->nullable();
        });
    }
};
