<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'content', 'file_attachment', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}