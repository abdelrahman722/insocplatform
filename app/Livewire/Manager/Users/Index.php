<?php

namespace App\Livewire\Manager\Users;

use Flux\Flux;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class Index extends Component
{
    use WithPagination, WireToast;

    public $role = 'all', $search = '';
    public function delete(User $id)
    {
        if (Auth::user()->id == $id->id) {
            Flux::modal('delete-user-' . $id->id)->close();
            return session()->flash('warning', 'user can\'t be delete becouse it\'s a currunt user.');
        }
        if(!$this->users->findOrFail($id)){
            return session()->flash('warning', 'user not fount.');
        }
        $id->delete();
        Flux::modal('delete-user-' . $id->id)->close();
        return toast()->success('user deleted.');
    }
    public function render()
    {
        $query = Auth::user()->school->users()->where('name', 'like', '%' . $this->search . '%');
        if ($this->role !== 'all') {
            $query->where('role', $this->role);
        }
        $users = $query->paginate(8);
        return view('livewire.manager.users.index', ['users' => $users]);
    }
}
