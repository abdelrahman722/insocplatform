<?php

namespace App\Livewire\Teacher;

use App\Models\Meeting;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class ManageMeetings extends Component
{
    use WireToast;
    public $meetings;

    public function mount()
    {
        $this->refreshMeetings();
    }

    public function confirm($id)
    {
        $meeting = Meeting::where('id', $id)->whereHas('availableSlot', fn($q) => $q->where('teacher_id', Auth::user()->teacher->id))->first();

        if ($meeting && $meeting->status === 'pending') {
            $meeting->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);
            toast()->success('meeting is confirmed.')->push();
        }

        $this->refreshMeetings();
    }

    public function reject($id)
    {
        $meeting = Meeting::where('id', $id)->whereHas('availableSlot', fn($q) => $q->where('teacher_id', Auth::user()->teacher->id))->first();

        if ($meeting && $meeting->status === 'pending') {
            $meeting->update(['status' => 'rejected']);
            toast()->success('meeting is Rejected.')->push();
        }

        $this->refreshMeetings();
    }

    private function refreshMeetings()
    {
        $this->meetings = Meeting::whereHas('availableSlot', fn($q) => $q->where('teacher_id', Auth::user()->teacher->id))->with([
            'guardian', // Guardian → User
            'student.user',  // Student → User
            'availableSlot'
        ])->whereIn('status', ['pending', 'confirmed', 'rejected'])->orderBy('scheduled_date')->orderBy('id')->get();
    }

    public function render()
    {
        return view('livewire.teacher.manage-meetings');
    }
}
