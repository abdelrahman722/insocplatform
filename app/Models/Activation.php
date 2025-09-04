<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'subscription_time',
        'created_by',
        'school_id',
        'programs',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'activation_program');
    }

    public function state()
    {
        return now()->lt($this->created_at->addMonths($this->subscription_time));
    } 
    
    public static function generateActiveCode()
    {
        return 'ACT' . strtoupper(bin2hex(random_bytes(8)));
    }
}
