<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Activation Requests') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Manage your All Activation Requests') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>
        <div class="overflow-x-auto p-3 ">
            

            @if ($requests->count())
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-4">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Requester Name</th>
                            <th scope="col" class="px-6 py-3">Phone</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Type</th>
                            <th scope="col" class="px-6 w-70 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $request)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">
                                    {{ $request->requester_name }}
                                </td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $request->phone }}</td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                    @if ($request->status == 'approved')
                                        <flux:badge color="green">{{ $request->status }}</flux:badge>
                                    @elseif ($request->status == 'rejected')
                                        <flux:badge color="red">{{ $request->status }}</flux:badge>
                                    @else
                                        <flux:badge>{{ $request->status }}</flux:badge>
                                    @endif
                                </td>
                                <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                                    @if ($this->chackSchool($request->notes))
                                        <flux:badge color="orange">{{ $this->chackSchool($request->notes)->name }}</flux:badge>
                                    @else
                                        <flux:badge color="yellow">new school</flux:badge>
                                    @endif
                                </td>
                                <td class="px-6 py-2">
                                    @if ($request->status == 'pending')
                                        <flux:modal.trigger :name="'show-requesr-'.$request->id">
                                            <flux:button icon="eye" size="xs" class="ml-1.5"></flux:button>
                                        </flux:modal.trigger>
                                        <flux:modal :name="'show-requesr-'.$request->id" class="md:w-1/2">
                                            <div class="space-y-6">
                                                <div>
                                                    <flux:heading size="lg">Request Activation</flux:heading>
                                                </div>
                                                <div>
                                                    <flux:heading>Name</flux:heading>
                                                    <flux:text class="mt-2">{{ $request->requester_name }}</flux:text>
                                                </div>
                                                <div>
                                                    <flux:heading>Phone</flux:heading>
                                                    <flux:text class="mt-2">{{ $request->phone }}</flux:text>
                                                </div>
                                                <div>
                                                    <flux:heading>Email</flux:heading>
                                                    <flux:text class="mt-2">{{ $request->email }}</flux:text>
                                                </div>
                                                <div>
                                                    <flux:heading>School Name</flux:heading>
                                                    <flux:text class="mt-2">{{ $request->school_name }}</flux:text>
                                                </div>
                                                <div>
                                                    <flux:heading>Requested Programs</flux:heading>
                                                    <flux:text class="mt-2">
                                                        @foreach ($request->getProgramsObjects() as $program)
                                                            <flux:badge>{{ $program->name }}</flux:badge>
                                                        @endforeach
                                                    </flux:text>
                                                </div>
                                                <div>
                                                    <flux:heading>Notes</flux:heading>
                                                    <flux:text class="mt-2">{{ $request->notes }}</flux:text>
                                                </div>

                                                <div class="flex">
                                                    <flux:spacer />
                                                    <flux:modal.close>
                                                        <flux:button variant="ghost" color="red" class="mr-3">cancel</flux:button>
                                                    </flux:modal.close>
                                                    <flux:button wire:click="rejecte({{$request->id}})" variant="primary" color="red" class="mr-3">Rejecte</flux:button>
                                                    <flux:button wire:click="approve({{$request->id}})" variant="primary" color="green" class="mr-3">Approve</flux:button>
                                                </div>
                                            </div>
                                        </flux:modal>
                                        <flux:modal :name="'approve-request-'.$request->id" class="md:w-1/2">
                                            <div class="space-y-6">
                                                <div>
                                                    <flux:heading size="lg">Approve Request Activation</flux:heading>
                                                </div>
                                                <div>
                                                    <flux:heading>Active </flux:heading>
                                                    <flux:text class="mt-2">
                                                        @foreach ($request->getProgramsObjects() as $program)
                                                            <flux:badge>{{ $program->name }}</flux:badge>
                                                        @endforeach
                                                    </flux:text>
                                                    <flux:heading class="mt-3">to <flux:badge color="green">{{ $request->school_name }}</flux:badge> School</flux:heading>
                                                </div>
                                                <flux:radio.group wire:model.live='type' label="Select your type of active">
                                                    <flux:radio value="trial_version" label="Trial (6 mouth)" />
                                                    <flux:radio value="paid_version" label="Paid" />
                                                    <flux:radio value="unlimited_version" label="Unlimited" />
                                                </flux:radio.group>
                                                <div class="@if ($type != 'paid_version') hidden @endif">
                                                    <flux:input wire:model="month" label="Number of mouth" type="number"  />
                                                </div>
                                                <div class="divide-y">
                                                    <div class="flex items-start space-x-3 py-6">
                                                        @foreach ($programs as $program)
                                                            <input wire:model="selected_program" type="checkbox" class="border-gray-300 rounded h-5 w-5" value="{{ $program->code }}" @checked($request->getProgramsObjects()->where('code', '=', $program->code)->first() ) />
                                                            <div class="flex flex-col">
                                                                <h1 class="font-medium leading-none">{{ $program->name }}</h1>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="flex">
                                                    <flux:spacer />
                                                    <flux:modal.close>
                                                        <flux:button variant="ghost" color="red" class="mr-3">cancel</flux:button>
                                                    </flux:modal.close>
                                                    <flux:button wire:click="confirmAprove({{$request->id}})" variant="primary" color="green" class="mr-3">Approve</flux:button>
                                                </div>
                                            </div>
                                        </flux:modal>
                                        <flux:modal :name="'rejecte-request-'.$request->id" class="md:w-1/2">
                                            <div class="space-y-6">
                                                <div>
                                                    <flux:heading size="lg">Rejecte Request Activation</flux:heading>
                                                </div>
                                                <flux:input type="text" label="Reason Of Rejecte" wire:model="rejection_reason" />
                                                <div class="flex">
                                                    <flux:spacer />
                                                    <flux:modal.close>
                                                        <flux:button variant="ghost" color="red" class="mr-3">cancel</flux:button>
                                                    </flux:modal.close>
                                                    <flux:button wire:click="confirmRejecte({{$request->id}})" variant="primary" color="red" class="mr-3">Rejecte</flux:button>
                                                </div>
                                            </div>
                                        </flux:modal>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <flux:callout>
                    <flux:callout.heading icon="newspaper">Request</flux:callout.heading>
                    <flux:callout.text>
                        No Request Send yat.
                    </flux:callout.text>
                </flux:callout>
            @endif
        </div>
    </div>
</div>
