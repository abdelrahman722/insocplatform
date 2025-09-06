<?php

namespace App\Livewire\Guardian;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chat extends Component
{
    public $conversationsUser;

    public function mount()
    {
        $this->conversationsUser = Auth::user()->guardian->teachers()->with('user')->get();
    }
    
    public function render()
    {
        return view('livewire.guardian.chat');
    }
}
