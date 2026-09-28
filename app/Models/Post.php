<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'excerpt',
        'content', 'image', 'published_at', 'views', 'is_published'
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_published' => 'boolean',
    ];

    public function getDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y') : '';
    }
}