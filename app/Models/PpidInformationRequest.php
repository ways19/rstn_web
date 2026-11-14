<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpidInformationRequest extends Model
{
    protected $table = 'ppid_information_requests';

    protected $fillable = [
        'ticket_number',
        'applicant_category',
        'nik',
        'name',
        'phone',
        'email',
        'address',
        'identity_file',
        'voice_recording',
        'information_detail',
        'purpose',
        'obtaining_method',
        'delivery_method',
        'status',
        'admin_note',
    ];
}