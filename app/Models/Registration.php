<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'queue_number', 'patient_type', 'nik', 'rm_number',
        'patient_name', 'phone', 'insurance', 'clinic',
        'doctor_name', 'visit_date', 'status'
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];
}