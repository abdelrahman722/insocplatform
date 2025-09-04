<?php

namespace App\Livewire\Components;

use Livewire\Component;

class AutocompleteInput extends Component
{
    public $options = [], $value = null, $search = '', $isOpen = false, $label = 'search', $placeholder = 'search or new';

    public function mount($options = [], $value = null, $label = 'search', $placeholder = 'search or new')
    {
        $this->options = $options;
        $this->value = $value;
        $this->label = $label;
        $this->placeholder = $placeholder;

        // تعيين نص البحث إذا كانت هناك قيمة
        if ($value) {
            $option = collect($this->options)->firstWhere('value', $value);
            $this->search = $option ? $option['label'] : $value;
        }
    }

    public function updatedSearch()
    {
        $this->isOpen = $this->hasMatchingOptions() && strlen($this->search) > 0;
    }

    public function hasMatchingOptions()
    {
        return collect($this->options)->filter(fn($option) => str_contains(strtolower($option['label']), strtolower($this->search)))->isNotEmpty();
    }

    public function selectOption($value, $label)
    {
        $this->value = $value;
        $this->search = $label;
        $this->isOpen = false;
        $this->dispatch('autocomplete-updated'. $this->label, value: $value, label: $label);
    }

    public function blur()
    {
        // عند فقدان التركيز، أغلق القائمة
        $this->isOpen = false;

        // إذا لم تكن هناك تطابق دقيق، اعتبره نصًا حرًا
        $matched = collect($this->options)->firstWhere('label', $this->search);
        if ($matched) {
            $this->value = $matched['value'];
            $this->dispatch('autocomplete-updated'. $this->label, value: $this->value, label: $this->search);
        } else {
            // القيمة الجديدة هي النص المكتوب
            $this->value = $this->search;
            $this->dispatch('autocomplete-updated'. $this->label, value: $this->search, label: $this->search);
        }
    }

    public function getFilteredOptionsProperty()
    {
        if (empty($this->search)) {
            return collect();
        }

        return collect($this->options)
            ->filter(fn($option) => str_contains(strtolower($option['label']), strtolower($this->search)))
            ->take(8);
    }

    public function render()
    {
        return view('livewire.components.autocomplete-input');
    }
}