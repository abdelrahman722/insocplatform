<?php

namespace App\Livewire\Manager\Teachers;

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
        $user->teacher?->delete();
        $user->delete(); // يحذف جميع الروابط من teacher_parent
        toast()->success('Teacher deleted.')->pushOnNextPage();
        return to_route('manager.teachers.index');
    }
    public function render()
    {
        $query = Auth::user()->school->users()->where('name', 'like', '%' . $this->search . '%')->where('role', 'teacher');
        $users = $query->paginate(8);
        return view('livewire.manager.teachers.index', ['users' => $users]);
    }
}
