<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\School;
use App\Models\Program;
use App\Models\Student;
use Livewire\Component;
use App\Models\Activation;

class Dashbord extends Component
{
    public $stats, $recentActivations;

    public function mount()
    {
        $this->stats['total_schools'] = School::get()->count();
        $this->stats['total_users'] = User::get()->count();
        $this->stats['active_schools'] = School::where('is_active', '=', true)->count();
        $this->stats['active_programs'] = Program::where('is_active', '=', true)->count();
        $this->stats['totalStudents'] = Student::get()->count();
        $this->recentActivations = Activation::with('school')
            ->latest()->take(3)->get();
    }
    public function render()
    {
        return view('livewire.admin.dashbord');
    }
}
