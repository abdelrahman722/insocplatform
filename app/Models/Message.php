<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id', 'sender_id', 'body', 'type', 'file_path', 'file_name', 'file_size', 'is_read', 'read_at' 
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function isFromTeacher()
    {
        return $this->sender->role === 'teacher';
    }

    public function isFromGuardian()
    {
        return $this->sender->role === 'guardian';
    }

    public function isImage()
    {
        return $this->type === 'image';
    }

    public function isFile()
    {
        return in_array($this->type, ['file', 'pdf', 'doc']);
    }

    public function isCall()
    {
        return in_array($this->type, ['voice_call', 'video_call']);
    }
}
