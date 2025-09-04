<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Add Teacher') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        <div class="grid grid-cols-2 gap-5 sm:grid-cols-2 lg:grid-cols-2 mb-8">
            <div >
                {{ __('Add A New Teacher') }}
            </div>
            <div class="text-right">
                <a href="{{ route('manager.teachers.index') }}"
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
                <flux:input wire:model="name" label="Name" />
                <flux:input wire:model="email" label="Email" type="email" />
                <flux:input wire:model="phone" label="Phone" />
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <flux:input wire:model="job_number" label="Job Number" />
                    <flux:input wire:model="job_title" label="Job Title" />
                </div>
                <p >password <flux:badge>password</flux:badge></p>
                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
            <div class="p-5">
                <div class="relative mb-5">
                    <div><p>Class and Section Information</p></div>
                    <flux:icon wire:click="addNewTeacherRel" icon="plus" class="cursor-pointer absolute right-2 top-1/2 transform -translate-y-1/2" />
                </div>
                @foreach ($this->semestersAndSections as $index => $semestersAndSection)
                    <div class="flex flex-row items-center justify-center border-b pb-2 mb-2">
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 basis-8/9">
                            <livewire:components.autocomplete-input
                                :options="$semesters"
                                label="Semester"
                                placeholder="Search Semester or Enter Anew"
                                wire:key="autocomplete-semester-{{ $index }}"
                            />
                            <livewire:components.autocomplete-input
                                :options="$sections"
                                label="Section"
                                placeholder="Search sections or Enter Anew"
                                wire:key="autocomplete-section-{{ $index }}"
                            />
                        </div>
                        <flux:icon icon="trash" wire:click="removeNewTeacherRel({{ $index }})" color="red" class="basis-1/9" />
                    </div>
                @endforeach
            </div>
        </div>
    </form>
</div>
