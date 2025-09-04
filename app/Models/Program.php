<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'icon',
        'is_active'
    ];

    public function activations()
    {
        return $this->belongsToMany(Activation::class, 'activation_program');
    }

}
