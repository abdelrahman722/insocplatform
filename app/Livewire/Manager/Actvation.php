<?php

namespace App\Livewire\Manager;

use App\Models\School;
use App\Models\Program;
use Livewire\Component;
use App\Models\Activation;
use App\Models\ActivationRequest;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;

class Actvation extends Component
{
    public $activation, $phone, $selected_program = [], $programs = [], $status = 'active', $schoolId;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->programs = Program::where('is_active', true)->get();
        $this->schoolId = Auth::user()->school_id;
        if($this->hasRequset()){
            return;
        }
        $this->activation = Activation::where('school_id', '=', $this->schoolId)
        ->first();
        $this->status = $this->activation ? ($this->isExpired($this->activation) ? 'expired' : 'active') : 'no_active';
    }

    private function isExpired($activation)
    {
        $endDate = $activation->created_at->addMonths($activation->subscription_time);
        return $endDate->isPast();
    }

    private function hasRequset()
    {
        $activationRequest = ActivationRequest::where('notes', $this->schoolId)
            ->where('status', 'pending')->get();
        if ($activationRequest->count()) {
            Flux::modal('request-active')->close();
            $this->status = 'requested';
            return true;
        }
        return false;
    }

    public function requestActivation()
    {
        $schoolId = Auth::user()->school_id;
        // تأكد من عدم وجود طلب مكرر
        if ($this->hasRequset()) {
            return;
        }
        $this->createRequestActivation($schoolId);
        $this->status = 'requested';
        Flux::modal('request-active')->close();
    }

    public function createRequestActivation($schoolId)
    {
        $this->validate([
            'phone' => 'required|string|max:20',
            'selected_program' => 'required|array|min:1',
            'selected_program.*' => 'exists:programs,code',
        ]);
        $schoolName = School::find($schoolId)->name;
        ActivationRequest::create([
            'notes' => $schoolId,
            'requester_name' => Auth::user()->name,
            'phone' => $this->phone,
            'email' => Auth::user()->email,
            'requested_programs' => $this->selected_program,
            'school_name' => $schoolName,
            'status' => 'pending',
        ]);
    }

    public function render()
    {
        return view('livewire.manager.actvation');
    }
}
