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
        Schema::create('ppid_documents', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->string('category');

            $table->unsignedSmallInteger('year')->default(2026);

            $table->enum('type', [
                'page',
                'file',
                'link',
                'video',
            ])->default('page');

            $table->string('url')->nullable();

            $table->string('file_path')->nullable();

            $table->foreignId('page_id')
                ->nullable()
                ->constrained('pages')
                ->nullOnDelete();

            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppid_documents');
    }
};
