<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'description', 'image',
        'cta_text', 'cta_link', 'cta_text2', 'cta_link2',
        'order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getBgAttribute()
    {
        return $this->image;
    }

    public function getDescAttribute()
    {
        return $this->description;
    }

    public function getCtaTextAttribute($value)
    {
        return $value ?: 'Pendaftaran Online';
    }

    public function getCtaLinkAttribute($value)
    {
        return $value ?: '/pendaftaran-online';
    }

    public function getCtaText2Attribute($value)
    {
        return $value ?: 'Jadwal Dokter';
    }

    public function getCtaLink2Attribute($value)
    {
        return $value ?: '/dokter';
    }
}