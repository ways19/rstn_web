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
        Schema::create('diklat_documentations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category', 30);
            $table->date('event_date');
            $table->string('location');
            $table->string('image_path');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['category', 'event_date']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diklat_documentations');
    }
};
