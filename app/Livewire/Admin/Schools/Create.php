<?php

namespace App\Livewire\Admin\Schools;

use App\Models\School;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Usernotnull\Toast\Concerns\WireToast;

class Create extends Component
{
    use WireToast;
    
    public $name, $email, $phone, $address;

    
    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $School = School::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'school_code' => School::generateSchoolCode(),
        ]);
        
        $this->createManager($School);
        toast()->success('school created.')->pushOnNextPage();
        return to_route('schools.index');
    }

    private function createManager(School $school) {
        $school->users()->create([
            'name' => 'manager school',
            'email' => $school->school_code . '@manager.com',
            'role' => 'manager',
            'password' => Hash::make( '123456')
        ]);
    }

    public function render()
    {
        return view('livewire.admin.schools.create');
    }
}
