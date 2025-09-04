<?php

namespace App\Livewire\Manager\Students;

use App\Models\Student;
use Livewire\Component;
use App\Models\Guardian;
use App\Models\Semester;
use App\Traits\CreateUserTrait;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class Create extends Component
{
    use CreateUserTrait, WireToast;

    public $school, $semesters, $guardian, $oldGuardian = '', $guardians = [], $newGuardians = [];
    public $student = [
        'name' => '',
        'email' => '',
        'password' => '',
        'phone' => '',
        'code' => '',
        'semester' => '',
    ];

    protected $listeners = [
        'autocomplete-updatedClass' => 'handleSemester'
    ];

    public function handleSemester($value, $label)
    {
        $this->student['semester'] = $label;
    }
    
    public function rules()
    {
        $rules = [
            'student.name' => 'required',
            'student.email' => 'email|unique:users,email',
            'newGuardians.*.name' => 'required',
        ];
        foreach ($this->newGuardians as $index => $guardian) {
            $emailRules = ['required', 'email'];
            // فقط تحقق من التفرد إذا لم يكن للولي ID (أي جديد)
            if (empty($guardian['id'])) {
                $emailRules[] = Rule::unique('users', 'email');
            }
            $rules["newGuardians.{$index}.email"] = $emailRules;
        }
        return $rules;
    }

    public function mount()
    {
        $this->semesters = Semester::all()->map(fn($u) => ['value' => $u->id, 'label' => $u->name])->toArray();
        $this->school = Auth::user()->school;
        $this->guardians = Guardian::all();
    }

    public function submit()
    {
        $this->validate();
        $student = $this->CreateStudent($this->school->id);
        $this->createStudentSubAcc($student);
        foreach ($this->newGuardians as $guardianData) {
            if (!empty($guardianData['name'])) {
                if ($guardianData['type'] === 'new') {
                    $this->setGuardianData($guardianData);
                    $guardian = $this->CreateGuardian( $this->school->id);
                    $student->guardians()->attach($guardian->id);
                } elseif($guardianData['type'] === 'old') {
                    $student->guardians()->attach($guardianData['id']);
                }
                $this->reset('guardian');
            }
        }
        $this->reset();
        $this->newGuardians = [];
        toast()->success('student created.')->pushOnNextPage();
        return to_route('manager.students.index');
    }

    public function setGuardianData(array $guardianData)
    {
        $this->guardian['name'] = $guardianData['name'];
        $this->guardian['email'] = $guardianData['email'];
        $this->guardian['phone'] = $guardianData['phone'];
    }

    public function createStudentSubAcc(Student $student)
    {
        $semester = Semester::firstOrCreate([
            'name' => $this->student['semester'],
            'school_id' => $student->school_id
        ]);
        $student->semester_id = $semester->id;
        $student->save();
    }

    public function addNewGuardian()
    {
        $this->newGuardians[] = ['name' => '', 'email' => '', 'phone' => '', 'type' => 'new'];
    }

    public function removeNewGuardian($index)
    {
        unset($this->newGuardians[$index]);
        $this->newGuardians = array_values($this->newGuardians);
    }

    public function updatedOldGuardian(Guardian $guardian)
    {
        $this->newGuardians[] = [
            'id' => $guardian->id,
            'name' => $guardian->user->name,
            'email' => $guardian->user->email,
            'phone' => $guardian->phone,
            'type' => 'old'
        ];
    }

    public function render()
    {
        return view('livewire.manager.students.create');
    }
}
