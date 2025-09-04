<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $fillable = ['code', 'phone', 'user_id', 'semester_id', 'school_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function sections()
    {
        return $this->hasManyThrough(Section::class, Semester::class);
    }

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class, 'guardian_student');
    }
    public function school()
    {
        return $this->hasOneThrough(School::class, User::class);
    }

    public function teachers()
    {
        $this->hasManyDeep(Teacher::class, [Semester::class, Section::class]);
    }
}
