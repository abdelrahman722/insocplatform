<?php

namespace App\Livewire\Manager\Guardians;

use App\Models\Student;
use Livewire\Component;
use App\Models\Guardian;
use App\Traits\CreateUserTrait;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class Create extends Component
{
    use CreateUserTrait, WireToast;

    public  $guardian = [], $oldStudent = '', $students = [], $newStudents = [];

    public function mount()
    {
        $this->students = Student::where('school_id', Auth::user()->school_id)->get();
    }

    public function rules()
    {
        return[
            'guardian.name' => 'required',
            'guardian.email' => 'required|email|unique:users,email',
            'guardian.phone' => 'required',
        ];
    }

    public function submit()
    {
        $this->validate();
        $guardian = $this->CreateGuardian(Auth::user()->school_id);
        $this->createGuardianStudentRel($guardian);
        $this->reset();
        $this->newStudents = [];
        toast()->success('guardian created.')->pushOnNextPage();
        return to_route('manager.guardians.index');
    }

    public function createGuardianStudentRel(Guardian $guardian)
    {
        $stusentIds = [];
        foreach($this->newStudents as $st){
            $stusentIds[] = $st['id']; 
        }
        $guardian->students()->attach($stusentIds );
    }

    public function removeNewGuardian($index)
    {
        unset($this->newStudents[$index]);
        $this->newStudents = array_values($this->newStudents);
    }

    public function updatedOldStudent(Student $student)
    {
        $this->newStudents[] = [
            'id' => $student->id,
            'name' => $student->user->name,
            'email' => $student->user->email,
            'phone' => $student->phone,
            'type' => 'old'
        ];
    }

    public function render()
    {
        return view('livewire.manager.guardians.create');
    }
}
