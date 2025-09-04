<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Teacher') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        <div class="grid grid-cols-2 gap-5 sm:grid-cols-2 lg:grid-cols-2">
            <div >
                {{ __('Manage your All Teachers') }}
            </div>
            <div class="text-right">
                <a href="{{ route('manager.teachers.create') }}" class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Create Teacher
                </a>
            </div>
        </div>
    </flux:subheading>
    <flux:separator variant="subtle" />
    <div>
        <div class="overflow-x-auto p-3">
            <div class="w-100 mt-3">
                @session('success')
                    <div class="flex items-center p-2 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900 dark:text-green-300 dark:border-green-800"
                        role="alert">
                        <svg class="flex-shrink-0 w-8 h-8 mr-1 text-green-700 dark:text-green-300"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                        </svg>
                        <span class="font-medium"> {{ $value }} </span>
                    </div>
                @endsession
                @session('warning')
                    <div class="flex items-center p-2 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-yellow-900 dark:text-yellow-300 dark:border-yellow-800"
                        role="alert">
                        <flux:icon class="flex-shrink-0 w-5 h-5 mr-1 text-yellow-700 dark:text-yellow-300" icon="exclamation-triangle"></flux:icon>
                        <span class="font-medium"> {{ $value }} </span>
                    </div>
                @endsession
            </div>
            @if ($users->count())
                <div class="grid grid-cols gap-5 lg:grid-cols-4">
                    <div class="col-start-4">
                        <flux:input placeholder="Search" wire:model.live='search' />
                    </div>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-4">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Phone</th>
                            <th scope="col" class="px-6 py-3">Section</th>
                            <th scope="col" class="px-6 w-70 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr
                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $user->name }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $user->teacher?->phone }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                    @if ($user->teacher?->sections?->count())
                                        @foreach ($user->teacher->sections as $section)
                                            <flux:badge>{{ $section->name }}</flux:badge>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="px-6 py-2">
                                    <flux:button href="{{ route('manager.teachers.edit', $user->id) }}" icon="pencil-square"
                                        size="xs" variant="primary" color="blue"></flux:button>

                                    <flux:modal.trigger name="delete-user-teacher-{{ $user->id }}">
                                        <flux:button icon="trash" size="xs" variant="danger" color="red" class="ml-1.5"></flux:button>
                                    </flux:modal.trigger>

                                    <flux:modal wire:key="delete-user-teacher-{{ $user->id }}" name="delete-user-teacher-{{ $user->id }}" class="min-w-[22rem]">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Delete {{ $user->name }}?</flux:heading>

                                                <flux:text class="mt-2">
                                                    <p>You're about to delete this {{ $user->name }} user.</p>
                                                    <p>This action cannot be reversed.</p>
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button  wire:click="delete({{ $user->id }})" variant="danger">Delete</flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            @else
                <flux:callout>
                    <flux:callout.heading icon="user-circle">Teacher</flux:callout.heading>
                    <flux:callout.text>
                        no teacher add yat.
                        <a href="{{ route('manager.teachers.create') }}"
                            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            Create Teacher
                        </a>
                    </flux:callout.text>
                </flux:callout>
            @endif
        </div>
    </div>
</div>
