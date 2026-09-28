<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'tag', 'excerpt',
        'description', 'facilities', 'image', 'order', 'is_active'
    ];

    protected $casts = [
        'facilities' => 'array',
        'is_active' => 'boolean',
    ];
}