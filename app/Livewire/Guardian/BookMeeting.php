<?php

namespace App\Livewire\Guardian;

use App\Models\Meeting;
use Livewire\Component;
use App\Models\AvailableSlot;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookMeeting extends Component
{

    public $teacherId = '', $studentId = '', $purpose, $selectedDate, $selectedSlotId, $monthName;
    public $teachers = [], $students, $monthlySlots = [], $currentMonth;

    public function mount()
    {
        $this->monthName = Carbon::now()->monthName;
        $this->currentMonth = now()->startOfMonth();
        // جلب جميع مدرسي المدرسة (أو يمكن تصفية حسب المدرسة)
        $this->students = Auth::user()->guardian->students;
        $this->teachers = $this->students->pluck('semester')->filter()->pluck('sections')->flatten()->pluck('teacher')->unique()->all();

        $this->generateMonthlySlots();
    }

    public function updatedTeacherId()
    {
        $this->selectedDate = null;
        $this->selectedSlotId = null;
        $this->generateMonthlySlots();
    }

    public function previousMonth()
    {
        $this->currentMonth = $this->currentMonth->subMonth()->startOfMonth();
        $this->monthName = $this->currentMonth->monthName;
        $this->selectedDate = null;
        $this->selectedSlotId = null;
        $this->generateMonthlySlots();
    }

    public function nextMonth()
    {
        $this->currentMonth = $this->currentMonth->addMonth()->startOfMonth();
        $this->monthName = $this->currentMonth->monthName;
        $this->selectedDate = null;
        $this->selectedSlotId = null;
        $this->generateMonthlySlots();
    }


    public function selectSlot($date, $slotId)
    {
        $this->selectedDate = $date;
        $this->selectedSlotId = $slotId;
    }


    private function generateMonthlySlots()
    {
        $this->monthlySlots = [];

        $startOfMonth = $this->currentMonth->copy();
        $endOfMonth = $this->currentMonth->copy()->endOfMonth();

        // احسب أول يوم (من يوم الأحد)
        $firstDay = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        // احسب آخر يوم (من يوم السبت)
        $lastDay = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);

        $current = $firstDay->copy();

        while ($current->lte($lastDay)) {
            $dayOfWeek = $current->dayOfWeek;

            // جلب الفترات المتاحة لهذا اليوم
            $availableSlots = AvailableSlot::where('teacher_id', $this->teacherId)
                ->where('day_of_week', $dayOfWeek)->get();

            // ✅ 2. استخراج أرقام الفترات المتاحة
            $availableSlotIds = $availableSlots->pluck('id');
            
            // جلب المواعيد المحجوزة لهذا اليوم
            $bookedSlotIds = Meeting::whereDate('scheduled_date', $current->format('Y-m-d'))
                ->whereIn('available_slot_id', $availableSlotIds)->pluck('available_slot_id');

            $this->monthlySlots[] = [
                'date' => $current->format('Y-m-d'),
                'day' => $current->day,
                'month' => $current->month,
                'year' => $current->year,
                'is_current_month' => $current->month === $this->currentMonth->month,
                'is_today' => $current->isToday(),
                'is_past' => $current->isPast(),
                'is_weekend' => in_array($dayOfWeek, [0, 6]), // الأحد = 0, السبت = 6
                'slots' => $availableSlots->map(function ($slot) use ($bookedSlotIds) {
                    return [
                        'id' => $slot->id,
                        'start_time' => Carbon::parse($slot->start_time)->format('H:i'),
                        'end_time' => Carbon::parse($slot->end_time)->format('H:i'),
                        'is_available' => !$bookedSlotIds->contains($slot->id),
                    ];
                })->toArray(),
            ];

            $current->addDay();
        }
    }

    public function book()
    {
        $this->validate([
            'teacherId' => 'required|exists:teachers,id',
            'selectedDate' => 'required|date|after_or_equal:today',
            'selectedSlotId' => 'required|exists:available_slots,id,teacher_id,' . $this->teacherId,
            'purpose' => 'nullable|string|max:500',
        ]);

        $slot = AvailableSlot::find($this->selectedSlotId);

        Meeting::create([
            'available_slot_id' => $this->selectedSlotId,
            'guardian_id' => Auth::user()->guardian->id,
            'student_id' => $this->studentId,
            'scheduled_date' => $this->selectedDate,
            'purpose' => $this->purpose,
            'status' => 'pending',
            'school_id' => Auth::user()->school_id,
        ]);

        toast()->success('meeting is resived.')->pushOnNextPage();
        return $this->redirect(route('guardian.dashboard'));
    }

    public function render()
    {
        return view('livewire.guardian.book-meeting');
    }
}
