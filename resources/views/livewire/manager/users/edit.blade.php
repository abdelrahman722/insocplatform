<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('edit User') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('edit user ' .$name) }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>
        <div class="overflow-x-auto p-3 ">
            <a href="{{ route('manager.users.index') }}"
                class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Back
            </a>
            <div class="w-150">
                <form class="mt-5 space-y-3" wire:submit="submit">
                    <flux:input wire:model="name" label="Name" />
                    <flux:input wire:model="email" label="Email" type="email" />
                    <flux:input wire:model="password" label="Password" type="password" />
                    <flux:input wire:model="confirm_password" label="Confirm Password" type="password" />
                    <flux:button type="submit" variant="primary">Save</flux:button>
                </form>
            </div>

        </div>
    </div>
</div>
