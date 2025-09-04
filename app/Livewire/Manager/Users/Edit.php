<?php

namespace App\Livewire\Manager\Users;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Usernotnull\Toast\Concerns\WireToast;

class Edit extends Component
{
    use WireToast;

    public $user, $name, $email, $password, $confirm_password;

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
        toast()->success('user updated.')->pushOnNextPage();
        return to_route('users.index');
    }

    public function mount($id)
    {
        $users = Auth::user()->school->users;
        $this->user = $users->findOrFail($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }
    public function render()
    {
        return view('livewire.manager.users.edit');
    }
}
