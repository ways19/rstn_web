
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diklat_registrations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('diklat_program_id')
                ->constrained('diklat_programs')
                ->restrictOnDelete();

            $table->string('registration_number')->unique();
            $table->string('full_name');
            $table->string('institution');
            $table->string('phone', 25);
            $table->string('email');
            $table->text('purpose')->nullable();

            $table->string('status')->default('diajukan');
            $table->text('admin_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diklat_registrations');
    }
};
