<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'content',
        'file_attachment',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)
            ->orderBy('sort_order');
    }

    public function accreditationCertificates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AccreditationCertificate::class)
            ->latest();
    }

    public function diklatGuidelines(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DiklatGuideline::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

}