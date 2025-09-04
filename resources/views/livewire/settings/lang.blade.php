<?php

use Livewire\Volt\Component;

new class extends Component {
    public $lang;

    public function mount()
    {
        $this->lang = auth()->user()->lang;
        session()->put("locala", auth()->user()->lang);
    }

    public function save()
    {
        auth()->user()->lang = $this->lang;
        auth()->user()->save();
        session()->put("locala", $this->lang);
        return redirect()->route('settings.lang');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('set.Language')" :subheading=" __('set.Update the Language settings for your account')">
        <flux:radio.group :label="__('set.Select Your Language')" wire:model="lang">
            <flux:radio value="en" label="{{ __('set.Engilsh') }}" />
            <flux:radio value="ar" label="{{ __('set.Arabic') }}" />
            <flux:button wire:click="save" variant="primary" class="mt-3">{{ __('set.Save') }}</flux:button>
        </flux:radio.group>
    </x-settings.layout>
</section>
