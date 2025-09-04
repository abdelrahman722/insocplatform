<?php

namespace App\Livewire\Manager\Students;

use App\Models\User;
use Livewire\Component;
use App\Models\Semester;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Usernotnull\Toast\Concerns\WireToast;

class Edit extends Component
{
    use WireToast;

    public $user, $name, $email, $phone, $semesters, $semester, $password, $confirm_password;
    protected $listeners = [
        'autocomplete-updatedClass' => 'handleSemester'
    ];

    public function handleSemester($value, $label)
    {
        $this->semester = $label;
    }

    public function submit()
    {
        // validate a data
        $this->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],
            'password' => 'same:confirm_password'
        ]);
        // update user
        $this->user->name = $this->name;
        $this->user->email = $this->email;
        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }
        $this->user->save();
        $student = $this->user->student;
        if(!empty($this->semester)){
            $semester = Semester::createOrFirst([
                'name' => $this->semester,
                'school_id' => $this->user->school_id
            ]);
            $student->semester_id = $semester->id;
        }
        $student->phone = $this->phone;
        $student->save();
        toast()->success('user updated.')->pushOnNextPage();
        return to_route('manager.students.index');
    }

    public function mount($id)
    {
        $schoolId = Auth::user()->school_id;
        $this->user = User::where('id', $id)->where('school_id', $schoolId)->first();
        if ($this->user === null) {
            return abort(404);
        }
        $this->semesters = Semester::where('school_id', $schoolId)->get()->map(fn($u) => ['value' => $u->id, 'label' => $u->name])->toArray();
        $this->setStudentProprty();
    }

    public function setStudentProprty()
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->student->phone;
    }

    public function render()
    {
        return view('livewire.manager.students.edit');
    }
}
