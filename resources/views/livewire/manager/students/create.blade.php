<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Add Student') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        <div class="grid grid-cols-2 gap-5 sm:grid-cols-2 lg:grid-cols-2 mb-8">
            <div >
                {{ __('Add A New Student') }}
            </div>
            <div class="text-right">
                <a href="{{ route('manager.students.index') }}"
                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Back
                </a>
            </div>
        </div>
    </flux:subheading>
    <flux:separator variant="subtle" />

    <form class="mt-5" wire:submit="submit">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-2 mb-8">
            <div class="overflow-x-auto p-5 space-y-3">
                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <flux:input wire:model="student.name" label="Name" />
                    <flux:input wire:model="student.code" label="Code" />
                </div>
                <flux:input wire:model="student.email" label="Email" type="email" />
                <flux:input wire:model="student.phone" label="Phone" />
                <livewire:components.autocomplete-input
                    :options="$semesters"
                    :value="$student['semester']"
                    label="Class"
                    placeholder="select a Class"
                    wire:key="semester-autocomplete"
                />
                <flux:error name="student['semester']" />
                <p >password <flux:badge>password</flux:badge></p>
                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
            <div class="p-5">
                <div class="relative mb-5">
                    <div><p>Parents Information</p></div>
                    <flux:icon wire:click="addNewGuardian" icon="plus" class="cursor-pointer absolute right-2 top-1/2 transform -translate-y-1/2" />
                </div>
                @if ($guardians->count())
                    <flux:select wire:model.live="oldGuardian" placeholder="Choose Aparent..." class="mb-3">
                        @foreach ($guardians as $guardian)
                            <flux:select.option value="{{ $guardian->id }}">{{ $guardian->user->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                @endif
                @foreach ($this->newGuardians as $index => $newParent)
                    <div class="flex flex-row items-center justify-center border-b pb-2 mb-2">
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-3 basis-8/9">
                            @if ($newParent['type'] == 'old')
                                <flux:input wire:model="newGuardians.{{ $index }}.name" disabled placeholder="Name" />
                                <flux:input wire:model="newGuardians.{{ $index }}.email" disabled placeholder="Email" type="email" />
                                <flux:input wire:model="newGuardians.{{ $index }}.phone" disabled placeholder="Phone" class="inline" />
                            @else
                                <flux:input wire:model="newGuardians.{{ $index }}.name" placeholder="Name" />
                                <flux:input wire:model="newGuardians.{{ $index }}.email" placeholder="Email" type="email" />
                                <flux:input wire:model="newGuardians.{{ $index }}.phone" placeholder="Phone" class="inline" />
                            @endif
                        </div>
                        <flux:icon icon="trash" wire:click="removeNewGuardian({{ $index }})" color="red" class="basis-1/9" />
                    </div>
                @endforeach
            </div>
        </div>
    </form>
</div>
