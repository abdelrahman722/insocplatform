<?php

namespace App\Livewire\Guardian;

use App\Models\Meeting;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UpcomingMeeting extends Component
{

    public $meetings;

    public function mount()
    {
        
        $this->meetings = Meeting::where('guardian_id', Auth::user()->guardian->id)->where('scheduled_date', '>=', now()->format('Y-m-d'))->whereIn('status', ['confirmed', 'pending'])
    ->join('available_slots', 'meetings.available_slot_id', '=', 'available_slots.id')
    ->join('users', 'available_slots.teacher_id', '=', 'users.id') // إذا كنت تستخدم اسم المدرس
    ->orderBy('meetings.scheduled_date')
    ->orderBy('available_slots.start_time')
    ->with(['availableSlot', 'availableSlot.teacher.user', 'student.user']) // للحصول على البيانات في النتائج
    ->select('meetings.*') // لتجنب تعارض الأعمدة
    ->get();
    }

    public function render()
    {
        return view('livewire.guardian.upcoming-meeting');
    }
}
