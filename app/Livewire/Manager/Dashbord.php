<?php

namespace App\Livewire\Manager;

use App\Models\Guardian;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashbord extends Component
{
   public $recentGuardians, $recentStudents, $totalGuardians, $totalTeachers, $totalStudents, $school;

    public function mount()
    {
        $this->school = Auth::user()->school;

        $this->totalStudents = Student::whereHas('user', fn($q) => $q->where('school_id', $this->school->id))->count();
        $this->totalTeachers = User::where('school_id', $this->school->id)->where('role', 'teacher')->count();
        $this->totalGuardians = Guardian::whereHas('user', fn($q) => $q->where('school_id', $this->school->id))->count();

        $this->recentStudents = Student::with('user')
            ->whereHas('user', fn($q) => $q->where('school_id', $this->school->id))
            ->latest()
            ->take(5)
            ->get();

        $this->recentGuardians = Guardian::with('user')
            ->whereHas('user', fn($q) => $q->where('school_id', $this->school->id))
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.manager.dashbord');
    }
}
