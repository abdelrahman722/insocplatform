<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Activations') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Manage your All Activations') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>
        <div class="overflow-x-auto p-3 ">
            

            @if ($activations->count())
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-4">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Code</th>
                            <th scope="col" class="px-6 py-3">Type</th>
                            <th scope="col" class="px-6 py-3">Subscription Time</th>
                            <th scope="col" class="px-6 py-3">Created By</th>
                            <th scope="col" class="px-6 py-3">School Name</th>
                            <th scope="col" class="px-6 py-3">Programs</th>
                            <th scope="col" class="px-6 py-3">Stutes</th>
                            <th scope="col" class="px-6 w-70 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activations as $activation)
                            <tr
                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $activation->id }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $activation->code }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $activation->type }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                    @if ($activation->subscription_time)
                                        {{ $activation->subscription_time }}
                                    @else
                                        Forever
                                    @endif
                                </td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $activation->user->name }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $activation->school->name }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300" >
                                    @foreach ($activation->programs as $program)
                                        <flux:badge class="my-1" size="sm">{{ $program->name }}</flux:badge>
                                    @endforeach
                                </td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                    @if ($activation->type == 'unlimited_version' || $activation->state())
                                        <flux:badge class="my-1" size="sm" color="green">Active</flux:badge>
                                    @else
                                        <flux:badge class="my-1" size="sm" color="red">Expired</flux:badge>
                                    @endif
                                </td>
                                <td class="px-6 py-2">
                                    <livewire:admin.activations.edit :activation="$activation" :key="$activation->id" />
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @else
                <flux:callout>
                    <flux:callout.heading icon="newspaper">Activation</flux:callout.heading>
                    <flux:callout.text>
                        no Activation add yat.
                    </flux:callout.text>
                </flux:callout>
            @endif
        </div>
    </div>
</div>
