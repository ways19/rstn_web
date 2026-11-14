<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PageSection extends Model
{
    protected $fillable = [
        'page_id',
        'title',
        'description',
        'level',
        'parent_id',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'level' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            PageSection::class,
            'parent_id'
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            PageSection::class,
            'parent_id'
        )->orderBy('sort_order');
    }

    public function placements(): HasMany
    {
        return $this->hasMany(PpidDocumentPlacement::class);
    }
}