<?php

namespace App\Livewire\Admin\Users;

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
        $id->delete();
        Flux::modal('delete-user-' . $id->id)->close();
        return toast()->success('user deleted.')->push();
    }
    public function render()
    {
        $query = User::query();
        if ($this->role !== 'all') {
            $query->where('role', $this->role);
        }
        $users = $query->where('name', 'like', '%' . $this->search . '%')->paginate(8);
        return view('livewire.admin.users.index', [
            'users' => $users
        ]);
    }
}
