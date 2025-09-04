<?php

namespace App\Livewire;

use App\Models\School;
use App\Models\Program;
use Livewire\Component;
use Livewire\Attributes\Layout;

class LandingPage extends Component
{
    public $programs;
    public $totalSchools;
    public $totalPrograms;

    public function mount()
    {
       try {
            // التأكد من وجود البرامج وتحويلها إلى array
            $this->programs = Program::where('is_active', true)->get()->toArray();
            // التأكد من العد
            $this->totalSchools = School::where('is_active', true)->count();
            $this->totalPrograms = Program::where('is_active', true)->count();
        } catch (\Exception $e) {
            // في حالة وجود خطأ، استخدام قيم افتراضية
            $this->programs = [];
            $this->totalSchools = 0;
            $this->totalPrograms = 0;
        }
    }

    #[Layout('layouts.landing')]
    public function render()
    {
        return view('livewire.landing-page');
    }
}