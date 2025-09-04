<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['job_number', 'job_title', 'phone', 'school_id'];

    public function school()
    {
        return $this->hasOneThrough(School::class, User::class);
    }

    public function availableSlots()
    {
        return $this->hasMany(AvailableSlot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function students()
    {
        return $this->hasManyThrough(Student::class, Section::class);
    }
    
    public function guardians()
    {
        return $this->hasManyDeepFromRelations(
            $this->sections(),           // Teacher → Sections
            (new Section)->semester(),   // Section → Semester
            (new Semester)->students(),  // Semester → Students
            (new Student)->guardians()   // Student → Guardians (many-to-many)
        )->distinct();
    }
}
