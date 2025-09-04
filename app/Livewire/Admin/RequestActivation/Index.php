<?php

namespace App\Livewire\Admin\RequestActivation;

use Flux\Flux;
use App\Models\School;
use App\Models\Program;
use Livewire\Component;
use App\Models\Activation;
use App\Models\ActivationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Usernotnull\Toast\Concerns\WireToast;

class Index extends Component
{
    use WireToast;

    public $requests, $approveRequest, $programs, $selected_program = [], $month, $type, $rejection_reason;

    public function chackSchool($note)
    {
        $school = School::where('id', '=', $note)->first();
        if ($school) {
            return $school;
        }
        return false;
    }

    public function updatedType()
    {
        if ($this->type !== 'paid_version') {
            $this->month = '';
        }
    }

    public function approve($id)
    {
        $this->approveRequest = ActivationRequest::findOrFail($id);
        Flux::modal('show-requesr-'. $id)->close();
        $this->selected_program = $this->approveRequest->requested_programs;
        Flux::modal('approve-request-'. $id)->show();
    }

    public function confirmAprove($id)
    {
        $this->validate([
            'type' => 'required|in:paid_version,trial_version,unlimited_version',
            'month' => 'required_if:type,paid_version|integer|gt:0',
            'selected_program' => 'required|array|min:1',
        ]);
        $this->checkMonths();
        $req = ActivationRequest::findOrFail($id);
        $school = $this->chackSchool($req->notes);
        if(!$school){
            $school = $this->createSchool($req);
            $this->createManager($school, $req->requester_name);
        }
        $this->activeAndUpdateSchool($school);
        Flux::modal('approve-request-'. $id)->close();
        $req->status = 'approved';
        $req->save();
        toast()->success('school and activation and manager of school created.')->pushOnNextPage();
        return to_route('activations.requests');
    }

    public function checkMonths()
    {
        if ($this->type === 'trial_version') {
            $this->month = 6;
        } elseif($this->type === 'unlimited_version') {
            $this->month = 1000;
        }
        return;
    }

    public function createSchool(ActivationRequest $req)
    {
        $school = School::create([
            'name' => $req->school_name,
            'email' => $req->email,
            'phone' => $req->phone,
            'school_code' => School::generateSchoolCode(),
        ]);
        return $school;
    }

    public function activeAndUpdateSchool(School $school)
    {
        $code = Activation::generateActiveCode();
        $activation = $school->activations()->create([
            'code' => $code,
            'type' => $this->type,
            'subscription_time' => $this->month,
            'created_by' => Auth::id(),
        ]);
        $programIds = Program::whereIn('code', $this->selected_program)->pluck('id')->toArray();
        foreach ($programIds as $programId) {
            $activation->programs()->attach($programId, ['school_id' => $activation->school_id]);
        }
        $school->is_active = true;
        $school->save();
    }

    public function createManager(School $school, string $name)
    {
        $school->users()->create([
            'name' => $name,
            'email' => $school->school_code . '@manager.com',
            'role' => 'manager',
            'password' => Hash::make( '123456')
        ]);
    }

    public function rejecte($id)
    {
        Flux::modal('show-requesr-'. $id)->close();
        Flux::modal('rejecte-request-'. $id)->show();
    }

    public function confirmRejecte($id)
    {
        $req = ActivationRequest::findOrFail($id);
        $req->rejection_reason = $this->rejection_reason;
        $req->status = 'rejected';
        $req->save();
        Flux::modal('rejecte-request-'. $id)->close();
        toast()->success('Activation Was Rejected.')->pushOnNextPage();
        return to_route('activations.requests');
    }

    public function render()
    {
        $this->requests = ActivationRequest::all();
        $this->programs = Program::where('is_active', '=', true)->get();
        return view('livewire.admin.request-activation.index');
    }
}
