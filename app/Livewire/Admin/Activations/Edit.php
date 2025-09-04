<?php

namespace App\Livewire\Admin\Activations;

use Flux\Flux;
use App\Models\Program;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Edit extends Component
{
    use WireToast;

    public $activation, $programs, $selected_program=[];

    public function edit()
    {
        $this->validate(['selected_program' => 'required|array|min:1']);
        $this->activation->programs()->sync($this->selected_program);
        Flux::modal('edit-active-' . $this->activation->id )->close();
        $this->reset('selected_program');
        $this->dispatch('activations.edited');
        return toast()->success('Program Edited.')->push();
    }

    public function mount()
    {
        $this->selected_program = $this->activation->programs->pluck('id')->toArray();
    }

    public function render()
    {
        $this->programs = Program::where('is_active', '=', true)->get();
        return view('livewire.admin.activations.edit');
    }
}
