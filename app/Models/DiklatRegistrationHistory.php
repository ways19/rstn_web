<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiklatRegistrationHistory extends Model
{
    protected $fillable = [
        'diklat_registration_id',
        'changed_by',
        'old_status',
        'new_status',
        'public_note',
        'internal_note',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(
            DiklatRegistration::class,
            'diklat_registration_id'
        );
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}