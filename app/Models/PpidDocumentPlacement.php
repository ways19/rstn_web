<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpidDocumentPlacement extends Model
{
    protected $fillable = [
        'ppid_document_id',
        'page_section_id',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(
            PpidDocument::class,
            'ppid_document_id'
        );
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(
            PageSection::class,
            'page_section_id'
        );
    }
}