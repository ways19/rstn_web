<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccreditationCertificate extends Model
{
    protected $fillable = [
        'page_id',
        'title',
        'file_path',
        'external_url',
        'certificate_date',
        'description',
        'is_active',
    ];

    protected $casts = [
        'certificate_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}