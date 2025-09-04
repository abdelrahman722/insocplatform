<div x-data="{ open: @entangle('isOpen').live }" class="relative">
    <!-- Label -->
    @if($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
        </label>
    @endif

    <!-- حقل إدخال عادي -->
    <input
        type="text"
        wire:model.live="search"
        placeholder="{{ $placeholder }}"
        x-ref="searchInput"
        x-on:focus="if (search.length > 0 && {{ $this->hasMatchingOptions() ? 'true' : 'false' }}) open = true"
        x-on:keydown.escape.window="open = false"
        x-on:keydown.tab="open = false"
        x-on:keydown.enter.prevent="$wire.blur()"
        class="w-full border rounded-lg block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5"
        wire:blur="blur"
    />

    <!-- القائمة المنسدلة (تظهر فقط عند الحاجة) -->
    <div
        x-show="open"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-50"
        x-cloak
        class="absolute z-10 w-full mt-1 bg-white border border-b-zinc-300/80 rounded-lg shadow-xs dark:bg-white/90 dark:border-white/10 max-h-40 overflow-auto"
    >
        <ul class="py-1 text-sm dark:text-gray-800">
            @foreach ($this->filteredOptions as $option)
                <li
                    wire:click="selectOption('{{ $option['value'] }}', '{{ $option['label'] }}')"
                    class="px-3 py-2 cursor-pointer hover:bg-indigo-100 dark:hover:bg-indigo-900/40"
                    x-on:click="open = false"
                >
                    {{ $option['label'] }}
                </li>
            @endforeach
        </ul>
    </div>
</div>