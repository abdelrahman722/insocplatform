<?php

namespace App\Livewire\Admin\Programs;

use App\Models\Program;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Usernotnull\Toast\Concerns\WireToast;

class Edit extends Component
{
    use WireToast;

    public $program, $name, $code, $description, $is_active;

    public function mount($id)
    {
        $this->program = Program::findOrFail($id);
        $this->name = $this->program->name;
        $this->code = $this->program->code;
        $this->description = $this->program->description;
        $this->is_active = $this->program->is_active;
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                Rule::unique('programs', 'code')->ignore($this->program->id),
            ],
            'description' => 'required|string|max:500',
            'is_active' => 'boolean',
        ]);

        $this->program->name = $this->name;
        $this->program->code = $this->code;
        $this->program->description = $this->description;
        $this->program->is_active = $this->is_active;
        $this->program->save();
        toast()->success('program Updated.')->pushOnNextPage();
        return to_route('programs.index');
    }
    public function render()
    {
        return view('livewire.admin.programs.edit');
    }
}
