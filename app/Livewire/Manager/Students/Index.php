<?php

namespace App\Livewire\Manager\Students;

use Flux\Flux;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class Index extends Component
{
    use WithPagination, WireToast;

    public $search = '';

    public function delete(User $user)
    {
        if(Auth::user()->school_id !== $user->school_id){
            return session()->flash('warning', 'user not fount.');
        }
        $user->student->guardians()->detach(); // يحذف جميع الروابط من student_parent
        $user->student->delete();
        $user->delete(); // يحذف جميع الروابط من student_parent
        
        Flux::modal('delete-user-student-' . $user->id)->close();
        return toast()->success('Student Deleted.')->push();
    }
    public function render()
    {
        $query = Auth::user()->school->users()->where('name', 'like', '%' . $this->search . '%')->where('role', 'student');
        $users = $query->paginate(8);
        return view('livewire.manager.students.index', ['users' => $users]);
    }
}
