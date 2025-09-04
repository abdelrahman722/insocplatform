<?php

namespace App\Livewire\Guardian;

use App\Models\Section;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $guardian, $school, $students, $subjects, $teachers;

    public function mount()
    {
        // جلب ولي الأمر المرتبط بالمستخدم الحالي
        $this->guardian = Auth::user()->guardian; // تأكد من تعريف العلاقة في نموذج User

        // جلب الطالب/الطلاب المرتبطين بولي الأمر
        $this->students = $this->guardian->students()->with('user', 'semester')->get();

        // جلب المدرسة من أول طالب (بما أن جميع الأبناء في نفس المدرسة غالبًا)
        $firstStudent = $this->students->first();
        $this->school = $firstStudent ? $firstStudent->user->school : null;
        
        // جلب المواد التي يدرسها أبناؤه (من خلال الفصول)
        $semesterIds = $this->students->pluck('semester_id')->unique();
        $this->subjects = Section::whereIn('semester_id', $semesterIds)->with('teacher.user')->get();

        // جلب المدرسين المرتبطين بمواد أبنائه
        $this->teachers = collect();
        foreach ($this->subjects as $subject) {
            if ($subject->teacher) {
                $this->teachers->push($subject->teacher);
            }
        }
        $this->teachers = $this->teachers->unique('id');
    }

    public function render()
    {
        return view('livewire.guardian.dashboard');
    }
}