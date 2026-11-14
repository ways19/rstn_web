
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diklat_programs', function (Blueprint $table) {
            $table->id();

            // Informasi program
            $table->string('category', 100);
            $table->string('name');
            $table->text('target')->nullable();
            $table->text('description')->nullable();

            // Jadwal dan kuota
            $table->string('schedule')->nullable();
            $table->string('duration')->nullable();
            $table->unsignedInteger('quota')->default(0);
            $table->unsignedInteger('remaining_quota')->default(0);

            // Pengaturan tampilan
            $table->string('status', 50)->default('dibuka');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diklat_programs');
    }
};
