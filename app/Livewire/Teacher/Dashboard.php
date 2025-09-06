<?php

namespace App\Livewire\Teacher;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $conversationsUser;

    public function mount()
    {
        $this->conversationsUser = Auth::user()->teacher->guardians()->with('user')->get();
    }
    
    public function render()
    {
        return view('livewire.teacher.dashboard');
    }
}
