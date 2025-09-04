<?php

namespace App\Livewire\Teacher;

use Livewire\Component;
use App\Models\AvailableSlot;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class SetAvailableSlots extends Component
{
    use WireToast;

    public $dayOfWeek = '', $startTime, $endTime, $availableSlots, $teacherId;

    public function mount()
    {
        $this->teacherId = Auth::user()->teacher->id;
        $this->refreshSlots();
    }

    public function addSlot()
    {
        $this->validate([
            'dayOfWeek' => 'required|integer|between:0,6',
            'startTime' => 'required|date_format:H:i',
            'endTime' => 'required|date_format:H:i|after:startTime',
        ]);

        // تأكد من أن الوقت لا يتعارض مع وقت موجود
        $conflict = AvailableSlot::where('teacher_id', $this->teacherId)
            ->where('day_of_week', $this->dayOfWeek)
            ->where(function ($query) {
                $query->whereBetween('start_time', [$this->startTime, $this->endTime])
                      ->orWhereBetween('end_time', [$this->startTime, $this->endTime])
                      ->orWhere(function ($q) {
                          $q->where('start_time', '<=', $this->startTime)
                            ->where('end_time', '>=', $this->endTime);
                      });
            })->exists();

        if ($conflict) {
            $this->addError('startTime', 'This Time Is Not Available');
            return;
        }

        AvailableSlot::create([
            'day_of_week' => $this->dayOfWeek,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'teacher_id' => Auth::user()->teacher->id,
            'school_id' => Auth::user()->school_id,
        ]);

        $this->reset(['dayOfWeek', 'startTime', 'endTime']);
        $this->refreshSlots();
        return toast()->success('meeting time is added.')->push();
    }

    public function deleteSlot($slotId)
    {
        $slot = AvailableSlot::where('id', $slotId)->where('teacher_id', $this->teacherId)->first();
        if (!$slot) {
            return toast()->success('meeting time is Not Find.')->push();
        }
        $slot->delete();
        $this->refreshSlots();
        return toast()->success('meeting time is Deleted.')->push();
    }

    private function refreshSlots()
    {
        $this->availableSlots = AvailableSlot::where('teacher_id', $this->teacherId)
            ->orderBy('day_of_week')->orderBy('start_time')->get();
    }

    public function render()
    {
        $days = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];

        return view('livewire.teacher.set-available-slots', compact('days'));
    }
}