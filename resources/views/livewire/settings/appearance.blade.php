<?php

use Livewire\Volt\Component;
use Flux\Flux;
new class extends Component {
    public $appearance;

    public function mount()
    {
        // جلب التفضيل من قاعدة البيانات
        $this->appearance = Auth::user()->dark_mode ? 'dark' : 'light';
    }

    public function save()
    {
        if ($this->appearance === 'dark') {
            // تحديث قاعدة البيانات
            Auth::user()->update(['dark_mode' => true]);
        }else{
            Auth::user()->update(['dark_mode' => false]);
        }
        return to_route('dashboard');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading=" __('Update the appearance settings for your account')">
        <flux:radio.group variant="segmented" wire:model="appearance">
            <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
        </flux:radio.group>
        <br>
            <flux:button wire:click="save" variant="primary" class="mt-3">{{ __('set.Save') }}</flux:button>
    </x-settings.layout>

</section>
