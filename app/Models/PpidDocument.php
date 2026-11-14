<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PpidDocument extends Model
{
    protected $fillable = [
        'title',
        'category',
        'year',
        'type',
        'url',
        'file_path',
        'page_id',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'year' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function placements(): HasMany
    {
        return $this->hasMany(
            PpidDocumentPlacement::class,
            'ppid_document_id'
        );
    }
}