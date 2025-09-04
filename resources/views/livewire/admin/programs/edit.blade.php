<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Edit Program') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Edit A ' . $program->name . ' Program') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>

        <div class="overflow-x-auto p-3 ">
            <a href="{{ route('programs.index') }}"
                class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Back
            </a>
            <div class="w-100">
                <form class="mt-5 space-y-3" wire:submit="submit">
                    <flux:input wire:model="name" label="Name" />
                    <flux:input wire:model="code" label="Code" />
                    <flux:input wire:model="description" label="Description" placeholder="Enter Description" />
                    <flux:button type="submit" variant="primary">Save</flux:button>
                </form>
            </div>

        </div>
    </div>
</div>
