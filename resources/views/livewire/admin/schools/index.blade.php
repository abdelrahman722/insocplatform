<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Schools') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Manage your All School') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>
        <div class="overflow-x-auto p-3 ">
            

            @if ($schools->count())
                <a href="{{ route('schools.create') }}"
                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Create School
                </a>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-4">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Stutes</th>
                            <th scope="col" class="px-6 w-70 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schools as $school)
                            <tr
                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $school->id }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $school->name }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $school->email }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                    @if ($school->is_active)
                                        <flux:badge size="sm" color="green">Active</flux:badge>
                                    @else
                                        <flux:badge size="sm" color="red">Not Active</flux:badge>
                                    @endif
                                </td>
                                <td class="px-6 py-2">
                                    <flux:button href="{{ route('schools.show', $school->id) }}" icon="eye"
                                        size="xs" variant="primary" color="gray"></flux:button>
                                    <flux:button href="{{ route('schools.edit', $school->id) }}" icon="pencil-square"
                                        size="xs" variant="primary" color="blue" class="ltr:ml-1.5 rtl:mr-1.5"></flux:button>

                                    <flux:modal.trigger name="delete-school-{{ $school->id }}">
                                        <flux:button icon="trash" size="xs" variant="danger" color="red"
                                            class="ltr:ml-1.5 rtl:mr-1.5"></flux:button>
                                    </flux:modal.trigger>

                                    <flux:modal name="delete-school-{{ $school->id }}" class="min-w-[22rem]">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Delete {{ $school->name }}?</flux:heading>

                                                <flux:text class="mt-2">
                                                    <p>You're about to delete this {{ $school->name }} school.</p>
                                                    <p>This action cannot be reversed.</p>
                                                </flux:text>
                                            </div>

                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button wire:click="delete({{ $school->id }})" variant="danger">
                                                    Delete</flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @else
                <flux:callout>
                    <flux:callout.heading icon="newspaper">schools</flux:callout.heading>
                    <flux:callout.text>
                        no school add yat.
                        <a href="{{ route('schools.create') }}"
                            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            Create School
                        </a>
                    </flux:callout.text>
                </flux:callout>
            @endif
        </div>
    </div>
</div>
