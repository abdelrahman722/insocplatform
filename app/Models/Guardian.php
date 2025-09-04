<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['phone', 'school_id'];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function teachers()
    {
        return $this->hasManyDeepFromRelations(
            $this->students(),           // أول علاقة: Guardian → Students
            (new Student)->semester(),   // Student → Semester
            (new Semester)->sections(),  // Semester → Sections
            (new Section)->teacher()     // Section → Teacher
        )->distinct();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
