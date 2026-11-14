
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_history_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('page_id')
                ->constrained('pages')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('position');
            $table->string('image_path');
            $table->string('alt_text')->nullable();

            $table->timestamps();

            $table->unique(['page_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_history_images');
    }
};
