<?php

namespace App\Livewire\Manager\Teachers;

use App\Models\Section;
use Livewire\Component;
use App\Models\Semester;
use App\Traits\CreateUserTrait;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class Create extends Component
{
    use CreateUserTrait, WireToast;

    public $name, $email, $phone, $job_number, $job_title;
    public $sections, $semesters, $semestersAndSections = [];

    public function mount()
    {
        $schoolId = Auth::user()->school_id;
        $this->semesters = Semester::where('school_id', $schoolId)->get()->map(fn($s) => [
            'value' => $s->id,
            'label' => $s->name
        ])->toArray();
        $this->sections = Section::where('school_id', $schoolId)->get()->map(fn($s) => [
            'value' => $s->id,
            'label' => $s->name
        ])->toArray();
    }

    public function rules()
    {
        return[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'job_number' => 'required',
            'job_title' => 'required',
        ];
    }

    public function submit()
    {
        $this->validate();
        $user = $this->CreateTeacher(Auth::user()->school_id);
        $this->createTeacherRel($user->teacher());
        $this->reset();
        $this->semestersAndSections = [];
        toast()->success('teacher created.')->pushOnNextPage();
        return to_route('manager.teachers.index');
    }

    public function createTeacherRel($teacher)
    {

    }
    public function addNewTeacherRel()
    {
        $this->semestersAndSections[] = [
            'semester' => ['id' => '', 'name' => ''],
            'section' => ['id' => '', 'name' => '', 'semester' => ''],
        ];
    }

    public function removeNewTeacherRel($index)
    {
        unset($this->semestersAndSections[$index]);
        $this->semestersAndSections = array_values($this->semestersAndSections);
    }

    public function render()
    {
        return view('livewire.manager.teachers.create');
    }
}
