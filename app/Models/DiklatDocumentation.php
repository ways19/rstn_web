<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiklatDocumentation extends Model
{
    protected $table = 'diklat_documentations';

    protected $fillable = [
        'title',
        'category',
        'event_date',
        'location',
        'image_path',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(
            DiklatDocumentationPhoto::class,
            'diklat_documentation_id'
        )->orderBy('sort_order');
    }
}