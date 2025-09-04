<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableSlot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['day_of_week', 'start_time', 'end_time', 'teacher_id', 'school_id',];

    protected $casts = [
        'day_of_week' => 'integer',
    ];
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
