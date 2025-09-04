<?php

namespace App\Livewire\Admin\RequestActivation;

use App\Models\Program;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\ActivationRequest;

class Create extends Component
{    
    public $requester_name, $phone, $email, $school_name, $notes, $programs = [], $availablePrograms = [];


    public function submit()
    {
        $this->validate([
            'requester_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'school_name' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'programs' => 'required|array|min:1',
            'programs.*' => 'exists:programs,code',
        ]);

        ActivationRequest::create([
            'requester_name' => $this->requester_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'school_name' => $this->school_name,
            'requested_programs' => $this->programs,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'تم إرسال طلب التفعيل بنجاح. سيتم مراجعته في أقرب وقت.');

        // إعادة تعيين النموذج
        $this->reset(['requester_name', 'phone', 'email', 'school_name', 'notes', 'programs']);
    }
    
    #[Layout('layouts.guest')]
    public function render()
    {
        $this->availablePrograms = Program::where('is_active', true)->get();
        return view('livewire.admin.request-activation.create');
    }
}
