<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'school_code',
        'activation_code'
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'subscription_start' => 'datetime', // Casts to a Carbon instance
        'subscription_end' => 'datetime',      // Casts to a Carbon instance (time part typically ignored)
    ];

    public function activations()
    {
        return $this->hasMany(Activation::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    
    public static function generateSchoolCode()
    {
        return 'SCH' . strtoupper(uniqid());
    }
}
