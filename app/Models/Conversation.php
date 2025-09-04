<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['user_id_1', 'user_id_2', 'title', 'is_active'];

    public function user_1()
    {
        return $this->belongsTo(User::class, 'user_id_1');
    }
    public function user_2()
    {
        return $this->belongsTo(User::class, 'user_id_2');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    // ✅ دالة مساعدة: هل هذا المستخدم جزء من المحادثة؟
    public function involvesUser($userId)
    {
        return $this->user_id_1 == $userId || $this->user_id_2 == $userId;
    }

    // ✅ دالة مساعدة: الحصول على الطرف الآخر
    public function getOtherUser($userId)
    {
        return $this->user_id_1 == $userId ? $this->user_2 : $this->user_1;
    }
}
