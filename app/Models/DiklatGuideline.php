<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class DiklatGuideline extends Model
{
    protected $fillable = [
        'page_id',
        'title',
        'description',
        'file_path',
        'external_url',
        'file_type',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function getDownloadUrlAttribute(): string
    {
        if ($this->file_path) {
            return route('information.diklat.guideline.download', $this);
        }

        if ($this->external_url) {
            return $this->external_url;
        }

        return '#';
    }

    public function getCleanFilenameAttribute(): string
    {
        $extension = $this->file_path
            ? pathinfo($this->file_path, PATHINFO_EXTENSION)
            : ($this->file_type ?: 'pdf');

        $cleanTitle = trim(preg_replace('/[\\\\\/:\*\?"<>\|]/', ' ', $this->title));

        return $cleanTitle . '.' . $extension;
    }

    public function getFormattedFileTypeAttribute(): string
    {
        return strtoupper($this->file_type ?: 'PDF');
    }
}
