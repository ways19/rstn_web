
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppid_objections', function (Blueprint $table) {
            // Nomor tiket khusus pengajuan keberatan
            $table->string('objection_ticket_number')
                ->nullable()
                ->unique();

            // Satu tiket permohonan hanya boleh memiliki
            // satu pengajuan keberatan
            $table->unique('ticket_number');
        });
    }

    public function down(): void
    {
        Schema::table('ppid_objections', function (Blueprint $table) {
            $table->dropUnique(
                'ppid_objections_objection_ticket_number_unique'
            );

            $table->dropUnique(
                'ppid_objections_ticket_number_unique'
            );

            $table->dropColumn('objection_ticket_number');
        });
    }
};
