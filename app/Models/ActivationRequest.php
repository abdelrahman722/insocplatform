<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_name',
        'phone',
        'email',
        'school_name',
        'requested_programs',
        'notes',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason'
    ];

    protected $casts = [
        'requested_programs' => 'array',
        'approved_at' => 'datetime'
    ];

    // علاقة مع المستخدم الذي وافق على الطلب
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // الحصول على البرامج ككائنات
    public function getProgramsObjects()
    {
        if (!$this->requested_programs) {
            return collect();
        }
        
        return Program::whereIn('code', $this->requested_programs)->get();
    }

    // التحقق من طلب برنامج معين
    public function hasProgram($programCode)
    {
        return in_array($programCode, $this->requested_programs ?? []);
    }

    // نطاق للطلبات المعلقة
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // نطاق للطلبات المعتمدة
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // نطاق للطلبات المرفوضة
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}