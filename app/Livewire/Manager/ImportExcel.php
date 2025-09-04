<?php

namespace App\Livewire\Manager;

use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Semester;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserSchoolImport;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class ImportExcel extends Component
{
    use WithFileUploads, WireToast;

    public $school, $file, $students = [], $guardians = [], $teachers = [], $errors = [];

    public $step = 1; // 1: رفع الملف، 2: مراجعة البيانات
    public $sampleData = [
        'Students' => [
            ['Name', 'Email', 'Code', 'Phone', 'Semester'],
            ['Ahmed Ali', 'ahmed@example.com', 'STU001', '+123456789', 'Grade 1'],
            ['Sara Mohamed', 'sara@example.com', 'STU002', '+987654321', 'Grade 2'],
        ],
        'Guardians' => [
            ['Name', 'Email', 'Phone', 'Student Codes'],
            ['Mohamed Taha', 'mohamed@example.com', '+1122334455', 'STU001, STU002'],
        ],
        'Teachers' => [
            ['Name', 'Email', 'Phone', 'Subject', 'Semester'],
            ['Laila Hassan', 'laila@example.com', '+5566778899', 'Math', 'Grade 1'],
        ],
    ];

    public function mount()
    {
        $this->school = Auth::user()->school;   
    }

    public function rules()
    {
        return [
            'file' => 'required|mimes:xlsx,xls,csv',
        ];
    }

    private function validateImpotData()
    {
        $errors = [];

        // التحقق من الطلاب
        foreach ($this->students as $index => $student) {
            if (empty($student['name'])) {
                $errors["students.{$index}.name"] = "Student name is required.";
            }
            if (empty($student['email']) || !filter_var($student['email'], FILTER_VALIDATE_EMAIL)) {
                $errors["students.{$index}.email"] = "Valid email is required.";
            }
            if (empty($student['code'])) {
                $errors["students.{$index}.code"] = "Student code is required.";
            }
            if (empty($student['semester'])) {
                $errors["students.{$index}.semester"] = "Semester is required.";
            }
        }

        // التحقق من أولياء الأمور
        foreach ($this->guardians as $index => $guardian) {
            if (empty($guardian['name'])) {
                $errors["guardians.{$index}.name"] = "Guardian name is required.";
            }
            if (empty($guardian['email']) || !filter_var($guardian['email'], FILTER_VALIDATE_EMAIL)) {
                $errors["guardians.{$index}.email"] = "Valid email is required.";
            }
            if (empty($guardian['phone'])) {
                $errors["guardians.{$index}.phone"] = "Valid phone is required.";
            }
            if (empty($guardian['student_codes'])) {
                $errors["guardians.{$index}.student_codes"] = "At least one student code is required.";
            }
        }

        // التحقق من المدرسين
        foreach ($this->teachers as $index => $teacher) {
            if (empty($teacher['name'])) {
                $errors["teachers.{$index}.name"] = "Teacher name is required.";
            }
            if (empty($teacher['email']) || !filter_var($teacher['email'], FILTER_VALIDATE_EMAIL)) {
                $errors["teachers.{$index}.email"] = "Valid email is required.";
            }
            if (empty($teacher['semesters'])) {
                $errors["teachers.{$index}.semesters"] = "Semesters is required.";
            }
            if (empty($teacher['section'])) {
                $errors["teachers.{$index}.section"] = "section is required.";
            }
        }

        return $errors;
    }

     public function next()
    {
        $this->validate();

        $this->importData();

        // التحقق من صحة البيانات
        $this->errors = $this->validateImpotData();

        if (empty($this->errors)) {
            $this->step = 2;
        }
        // إذا كانت هناك أخطاء، تبقى في الخطوة 1 وتُعرض الأخطاء
    }

    /**
     * العودة إلى خطوة رفع الملف
     */
    public function previous()
    {
        $this->step = 1;
        // (اختياري) مسح الملف الحالي
        $this->reset('file');
        // (اختياري) مسح البيانات المؤقتة
        $this->students = [];
        $this->guardians = [];
        $this->teachers = [];
    }

    public function importData()
    {
        $import = new UserSchoolImport();
        $import->data = [];
        Excel::import($import, $this->file->getRealPath());

        $this->students = $import->data['Students'] ?? [];
        $this->guardians = $import->data['Guardians'] ?? [];
        $this->teachers = $import->data['Teachers'] ?? [];
    }

    public function save()
    {
        $this->createStudents();
        $this->createGuardians();
        $this->createTeachers();

        toast()->success('Data Imported Success')->pushOnNextPage();
        return to_route('manager.dashboard');
    }

    private function createStudents()
    {
        foreach ($this->students as $data) {
            $semester = Semester::firstOrCreate([
                'name' => $data['semester'],
                'school_id' => $this->school->id
            ]);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'school_id' => $this->school->id,
                'role' => 'student',
                'password' => bcrypt('password123'), // كلمة السر الموحدة
            ]);

            $user->student()->create([
                'code' => $data['code'],
                'phone' => $data['phone'],
                'semester_id' => $semester->id,
                'school_id' => $this->school->id
            ]);
        }
    }

    private function createGuardians()
    {
        foreach ($this->guardians as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'school_id' => $this->school->id,
                'role' => 'guardian',
                'password' => bcrypt('password123'),
            ]);

            $guardian = $user->guardian()->create([
                'school_id' => $this->school->id,
                'phone' => $data['phone'],
            ]);

            // ربط أولياء الأمور بالطلاب
            $codes = explode(',', $data['student_codes']);
            $studentIds = Student::whereIn('code', $codes)->pluck('id');
            $guardian->students()->attach($studentIds);
        }
    }

    private function createTeachers()
    {
        foreach ($this->teachers as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'school_id' => $this->school->id,
                'role' => 'teacher',
                'password' => bcrypt('password123'),
            ]);

            $teacher = $user->teacher()->create([
                'job_number' => $data['job_number'],
                'job_title' => $data['job_title'],
                'phone' => $data['phone'],
                'school_id' => $this->school->id,
            ]);

            $semestersName = explode(',', $data['semesters']);
            foreach ($semestersName as $semester) {
                $semester = Semester::firstOrCreate([
                    'name' => $semester,
                    'school_id' => $this->school->id,
                ]);
                $section = $semester->sections()->firstOrCreate([
                    'name' => $data['section'],
                    'school_id' => $this->school->id,
                    'teacher_id' => $teacher->id,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.manager.import-excel');
    }
}
