<div>
    <flux:modal.trigger name="edit-active-{{ $activation->id }}">
        <flux:button icon="pencil-square" size="xs" variant="primary" color="blue" class="ml-1.5"></flux:button>
    </flux:modal.trigger>

    <flux:modal name="edit-active-{{ $activation->id }}" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Active</flux:heading>
            </div>
            <flux:checkbox.group wire:model='selected_program' label="Programs" class="space-y-2">
                @foreach ($programs as $program)
                    <flux:checkbox value="{{ $program->id }}" label="{{ $program->name }}"  />
                @endforeach
            </flux:checkbox.group>

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="edit" variant="primary">Active Now</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
