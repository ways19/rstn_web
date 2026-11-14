<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiklatDocumentationPhoto extends Model
{
    protected $table = 'diklat_documentation_photos';

    protected $fillable = [
        'diklat_documentation_id',
        'image_path',
        'sort_order',
    ];

    public function documentation(): BelongsTo
    {
        return $this->belongsTo(
            DiklatDocumentation::class,
            'diklat_documentation_id'
        );
    }
}