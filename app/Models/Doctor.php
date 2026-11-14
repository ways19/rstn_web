<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public static function formatPhotoUrl(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        // Konversi otomatis link Google Drive ke direct thumbnail/image URL
        if (preg_match('/(?:drive\.google\.com\/(?:file\/d\/|open\?id=|uc\?(?:.*&)?id=)|docs\.google\.com\/(?:file\/d\/))([a-zA-Z0-9_-]+)/i', $value, $matches)) {
            return "https://drive.google.com/thumbnail?id={$matches[1]}&sz=w1000";
        }

        return $value;
    }

    public function getPhotoAttribute($value): ?string
    {
        if (!$value) {
            return null;
        }

        // Jika link Google Drive, ubah otomatis ke direct image URL
        if (preg_match('/(?:drive\.google\.com\/(?:file\/d\/|open\?id=|uc\?(?:.*&)?id=)|docs\.google\.com\/(?:file\/d\/))([a-zA-Z0-9_-]+)/i', $value, $matches)) {
            return "https://drive.google.com/thumbnail?id={$matches[1]}&sz=w1000";
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') || str_starts_with($value, '/')) {
            return $value;
        }

        return Storage::disk('public')->url($value);
    }
}
