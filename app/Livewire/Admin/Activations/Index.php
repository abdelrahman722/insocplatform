<?php

namespace App\Livewire\Admin\Activations;

use Livewire\Component;
use App\Models\Activation;
use Livewire\Attributes\On;

class Index extends Component
{
    public $activations;

    #[On('activations.edited')] 
    public function updateActivations()
    {
        $this->activations = Activation::get();
    }

    public function mount()
    {
        $this->activations = Activation::get();
    }

    public function render()
    {
        return view('livewire.admin.activations.index');
    }
}
