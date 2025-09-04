<?php

namespace App\Livewire\Admin\Schools;

use Flux\Flux;
use App\Models\School;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Index extends Component
{
    use WireToast;
    public function delete(School $id)
    {
        $id->delete();
        Flux::modal('delete-school-' . $id->id)->close();
        return toast()->success('school deleted.')->push();
    }

    public function render()
    {
        $schools = School::all();
        return view('livewire.admin.schools.index')->with('schools', $schools);
    }
}
