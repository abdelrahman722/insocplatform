<?php

namespace App\Livewire\Admin\Schools;

use App\Models\School;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Usernotnull\Toast\Concerns\WireToast;

class Edit extends Component
{
    use WireToast;

    public $school, $name, $email, $phone, $address;

    public function mount($id)
    {
        $this->school = School::findOrFail($id);
        $this->name = $this->school->name;
        $this->email = $this->school->email;
        $this->phone = $this->school->phone;
        $this->address = $this->school->address;
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('schools', 'email')->ignore($this->school->id),
            ],
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $this->school->name = $this->name;
        $this->school->email = $this->email;
        $this->school->phone = $this->phone;
        $this->school->address = $this->address;
        $this->school->save();
        
        toast()->success('school Updated.')->pushOnNextPage();
        return to_route('schools.index');
    }

    public function render()
    {
        return view('livewire.admin.schools.edit');
    }
}
