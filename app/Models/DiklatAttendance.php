<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiklatAttendance extends Model
{
    protected $fillable = [
        'diklat_program_id',
        'full_name',
        'institution',
        'identity_key',
        'attended_at',
    ];

    protected function casts(): array
    {
        return [
            'attended_at' => 'datetime',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(
            DiklatProgram::class,
            'diklat_program_id'
        );
    }
}