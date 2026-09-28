<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppModule extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'group',
        'description',
        'icon',
        'route_name',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
