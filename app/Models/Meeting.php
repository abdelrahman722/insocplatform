<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'available_slot_id',
        'guardian_id',
        'student_id',
        'scheduled_date',
        'purpose',
        'notes_guardian',
        'notes_teacher',
        'status',
        'school_id',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function availableSlot()
    {
        return $this->belongsTo(AvailableSlot::class);
    }

    public function guardian()
    {
        return $this->belongsTo(User::class, 'guardian_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->availableSlot->teacher;
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
