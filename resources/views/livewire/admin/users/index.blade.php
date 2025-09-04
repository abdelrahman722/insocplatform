<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        <div class="grid grid-cols-2 gap-5 sm:grid-cols-2 lg:grid-cols-2 mb-8">
            <div >
                {{ __('Manage your All Users') }}
            </div>
            <div class="ltr:text-right rtl:text-left">
                <a href="{{ route('users.create') }}"
                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Create User
                </a>
            </div>
        </div>
    </flux:subheading>
    <flux:separator variant="subtle" />

    <div>
        <div class="overflow-x-auto p-3 ">
            <div class="grid grid-cols gap-5 lg:grid-cols-4">
                <div class="col-span-2">
                    <flux:radio.group wire:model.live="role" variant="segmented">
                        <flux:radio label="All" value="all" selected />
                        <flux:radio label="Admin" value="admin" />
                        <flux:radio label="Manager" value="manager" />
                        <flux:radio label="Student" value="student" />
                        <flux:radio label="Parent" value="guardian" />
                        <flux:radio label="Teacher" value="teacher" />
                        <flux:radio label="Employee" value="employee" />
                    </flux:radio.group>
                </div>
                <div class="col-start-4">
                    <flux:input placeholder="Search" wire:model.live='search' />
                </div>
            </div>
            
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 w-70 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $user->id }}</td>
                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $user->name }}</td>
                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                            <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $user->role }}</td>
                            <td class="px-6 py-2">
                                <flux:button href="{{ route('users.edit', $user->id) }}" icon="pencil-square"
                                    size="xs" variant="primary" color="blue"></flux:button>

                                <flux:modal.trigger name="delete-user-{{ $user->id }}">
                                    <flux:button icon="trash" size="xs" variant="danger" color="red" class="ltr:ml-1.5 rtl:mr-1.5"></flux:button>
                                </flux:modal.trigger>

                                <flux:modal name="delete-user-{{ $user->id }}" class="min-w-[22rem]">
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
        </div>
    </div>
</div>
