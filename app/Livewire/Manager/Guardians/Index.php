<?php

namespace App\Livewire\Manager\Guardians;

use Flux\Flux;
use App\Models\User;
use App\Models\Guardian;
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
        $user->guardian->students()->detach(); // يحذف جميع الروابط من student_parent
        $user->guardian->delete();
        $user->delete(); // يحذف جميع الروابط من guardian_parent
        Flux::modal('delete-user-guardian-' . $user->id)->close();
        return toast()->success('Guardian deleted.')->push();
    }
    public function render()
    {
        $query = Auth::user()->school->users()->where('name', 'like', '%' . $this->search . '%')->where('role', 'guardian');
        $users = $query->paginate(8);
        return view('livewire.manager.guardians.index', ['users' => $users]);
    }
}
