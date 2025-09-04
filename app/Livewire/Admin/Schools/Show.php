<?php

namespace App\Livewire\Admin\Schools;

use Flux\Flux;
use App\Models\School;
use App\Models\Program;
use Livewire\Component;
use App\Models\Activation;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class Show extends Component
{
    use WireToast;

    public $programs, $school, $selected_program, $month, $type;

    public function updatedType()
    {
        if ($this->type !== 'paid_version') {
            $this->month = '';
        }
    }
    public function active()
    {
        $code = Activation::generateActiveCode();
        $activation = $this->activation($code);
        $activation->programs()->attach($this->selected_program, ['school_id' =>$this->school->id]);
        $this->updateSchool($code);
        Flux::modal('active-school-' . $this->school->id )->close();
        return toast()->success('school active success.')->push();
    }

    public function activation(string $code)
    {
        $this->validate([
            'type' => 'required|in:paid_version,trial_version,unlimited_version',
            'month' => 'required_if:type,paid_version|integer|gt:0',
            'selected_program' => 'required|array|min:1',
        ]);

        if ($this->type == 'trial_version') {
            $this->month = 6;
        }

        return Activation::create([
            'code' => $code,
            'type' => $this->type,
            'subscription_time' => $this->month,
            'created_by' => Auth::id(),
            'school_id' => $this->school->id,
        ]);
    }

    public function updateSchool(string $code)
    {
        $subscription_end = now()->addMonths((int)$this->month);
        $this->school->is_active = true;
        $this->school->subscription_start = now();
        $this->school->subscription_end = $subscription_end;
        $this->school->save();
    }

    public function mount($id)
    {
        $this->school = School::findOrFail($id);
        $this->programs = Program::where('is_active', '=' , true)->get();
    }
    public function render()
    {
        return view('livewire.admin.schools.show');
    }
}
