<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $fillable = [
        'class_name', 'total', 'available', 'occupied',
        'gender_room', 'order'
    ];

    public function getClassAttribute()
    {
        return $this->class_name;
    }

    public function getGenderAttribute()
    {
        return $this->gender_room;
    }
}