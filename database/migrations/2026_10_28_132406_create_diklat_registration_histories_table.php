
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diklat_registration_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('diklat_registration_id')
                ->constrained('diklat_registrations')
                ->cascadeOnDelete();

            $table->foreignId('changed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('old_status')->nullable();
            $table->string('new_status');
            $table->text('public_note')->nullable();
            $table->text('internal_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diklat_registration_histories');
    }
};
