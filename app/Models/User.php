<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'school_id',
        'dark_mode',
        'lang'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     *
     * @return string
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
    
    /**
     * Get School Of Users
     *
     * @return BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    
    /**
     * teacher
     *
     * @return HasOne|null
     */
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
    
    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function profile()
    {
        return $this->hasOne(config("roles.{$this->role}.model"));
    }
    
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user_id_1')->orWhere('user_id_2', $this->id);
    }

    public function conversationsAsUser1()
    {
        return $this->hasMany(Conversation::class, 'user_id_1');
    }

    public function conversationsAsUser2()
    {
        return $this->hasMany(Conversation::class, 'user_id_2');
    }
}
