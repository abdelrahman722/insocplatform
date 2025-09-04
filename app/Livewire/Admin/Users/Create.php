<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Models\School;
use App\Traits\CreateUserTrait;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Usernotnull\Toast\Concerns\WireToast;

class Create extends Component
{
    use CreateUserTrait, WireToast;

    public $name, $email, $role, $school_id, $schools, $password, $admin, $manager;
    
    /**
     * rules
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => ['required', Rule::in('admin', 'manager')],
            'school_id' => 'required_if:role,manager',
        ];
    }

    public function submit()
    {
        $this->validate();
        if ($this->role === 'admin') {
            $this->admin['name'] = $this->name;
            $this->admin['email'] = $this->email;
            $this->admin['password'] = $this->password;
            $user = $this->CreateAdmin();
        } elseif($this->role === 'manager') {
            $this->manager['name'] = $this->name;
            $this->manager['email'] = $this->email;
            $this->manager['password'] = $this->password;
            $user = $this->CreateManager($this->school_id);
        }
        toast()->success('user ' . $user->name . ' created.')->pushOnNextPage();
        return to_route('users.index');
    }

    public function render()
    {
        $this->schools = School::all();
        $this->password = Str::random(8);
        return view('livewire.admin.users.create');
    }
}
