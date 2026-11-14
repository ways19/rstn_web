<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppid_document_menus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ppid_document_id')
                ->constrained('ppid_documents')
                ->cascadeOnDelete();

            $table->string('menu');
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->unique(['ppid_document_id', 'menu']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppid_document_menus');
    }
};