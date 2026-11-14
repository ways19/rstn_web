<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    protected $fillable = [
        'title',
        'category',
        'description',
        'image_path',
        'label',
        'caption',
        'link_url',
        'link_label',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(FacilityPhoto::class)
            ->orderBy('sort_order');
    }
}
