<?php

namespace App\Livewire\Admin\Programs;

use App\Models\Program;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Index extends Component
{
    use WireToast;
    public function change($id)
    {
        $program = Program::find($id);
        $program->is_active = !$program->is_active;
        $program->save();
        return toast()->success('changed success');
    }
    
    public function render()
    {
        $programs = Program::all();
        return view('livewire.admin.programs.index')->with('programs', $programs);
    }
}
