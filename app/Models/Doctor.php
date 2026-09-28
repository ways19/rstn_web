<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'speciality', 'sub_speciality', 'poli',
        'schedule', 'days', 'experience', 'education',
        'photo', 'order', 'is_active'
    ];

    protected $casts = [
        'days' => 'array',
        'is_active' => 'boolean',
    ];
}