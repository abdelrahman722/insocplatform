<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Programs') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Manage your All Program') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>
        <div class="overflow-x-auto p-3 ">
            

            @if ($programs->count())
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-4">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Code</th>
                            <th scope="col" class="px-6 py-3">description</th>
                            <th scope="col" class="px-6 py-3">Icon</th>
                            <th scope="col" class="px-6 py-3">Stutes</th>
                            <th scope="col" class="px-6 w-70 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programs as $program)
                            <tr
                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $program->id }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $program->name }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $program->code }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $program->description }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                    <flux:icon icon="{{ $program->icon }}"></flux:icon>
                                </td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                    @if ($program->is_active)
                                        <flux:badge size="sm" color="green">Active</flux:badge>
                                    @else
                                        <flux:badge size="sm" color="red">Not Active</flux:badge>
                                    @endif
                                </td>
                                <td class="px-6 py-2">
                                    <flux:button href="{{ route('programs.edit', $program->id) }}" icon="pencil-square" size="xs" variant="primary" color="blue" class="ml-1.5"></flux:button>
                                    @if ($program->is_active)
                                        <flux:button type="button" wire:click='change( {{ $program->id }} )' icon="pause-circle" size="xs" variant="primary" color="red" class="ml-1.5"></flux:button>
                                        
                                    @else
                                        <flux:button wire:click="change({{ $program->id }})" icon="play-circle" size="xs" variant="primary" color="green" class="ml-1.5"></flux:button>
                                    @endif
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
