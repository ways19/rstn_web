<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpidObjection extends Model
{
    protected $table = 'ppid_objections';

    protected $fillable = [
        'ticket_number',
        'objection_ticket_number',
        'information_purpose',
        'applicant_name',
        'applicant_phone',
        'applicant_address',
        'representative_name',
        'representative_phone',
        'representative_address',
        'objection_reasons',
        'objection_chronology',
        'voice_recording',
        'status',
        'admin_note',
    ];
}