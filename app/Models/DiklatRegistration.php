<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiklatRegistration extends Model
{
    
    protected $fillable = [
        'diklat_program_id',
        'registration_number',
        'access_token',

        'full_name',
        'institution',
        'phone',
        'email',
        'purpose',
        'application_letter_path',
        'participant_list_path',
        'insurance_proof_path',
        'id_photo_path',
        'payment_proof_path',
        'payment_sender_name',
        'payment_sender_account_number',
        'payment_sender_bank',

        'study_program',
        'education_level',
        'practice_type',
        'practice_start_date',
        'practice_end_date',
        'profession',
        'position',
        'str_number',
        'str_file_path',
        'satusehat_id',
        'assignment_letter_path',

        'status',
        'admin_notes',
        'admin_internal_notes',
        'completion_confirmed_at',
    ];

    protected function casts(): array
    {
        return [
            'practice_start_date' => 'date',
            'practice_end_date' => 'date',
            'completion_confirmed_at' => 'datetime',
        ];
    }

    /**
     * Mendapatkan daftar seluruh path pas foto yang diunggah (mendukung banyak foto).
     */
    public function getIdPhotosAttribute(): array
    {
        if (empty($this->id_photo_path)) {
            return [];
        }

        $decoded = json_decode($this->id_photo_path, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        return [$this->id_photo_path];
    }

    protected static function booted(): void
    {
        static::saved(function (DiklatRegistration $registration) {
            if ($registration->isDirty('diklat_program_id')) {
                $oldProgramId = $registration->getOriginal('diklat_program_id');
                if ($oldProgramId) {
                    DiklatProgram::find($oldProgramId)?->recalculateRemainingQuota();
                }
            }

            $registration->program?->recalculateRemainingQuota();
        });

        static::deleted(function (DiklatRegistration $registration) {
            $registration->program?->recalculateRemainingQuota();
        });
    }

    /**
     * Program Diklat yang dipilih oleh pendaftar.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(
            DiklatProgram::class,
            'diklat_program_id'
        );
    }

    public function histories(): HasMany
    {
        return $this->hasMany(
            DiklatRegistrationHistory::class,
            'diklat_registration_id'
        )->latest();
    }
}