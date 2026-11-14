<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpidDocumentMenu extends Model
{
    protected $fillable = [
        'ppid_document_id',
        'menu',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(PpidDocument::class, 'ppid_document_id');
    }
}