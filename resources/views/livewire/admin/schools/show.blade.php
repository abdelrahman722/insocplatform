<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('School Details') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ $school->name . ' code( ' . $school->school_code . ' )' }}
    </flux:subheading>
    <flux:separator variant="subtle" />

    <div class="grid grid-cols-7 gap-10">
        <div class="p-5 col-span-4">
            <!-- List -->
            <div class="space-y-4  mb-16">
                <h2>Gaenral Details</h2>
                <dl class="flex flex-col sm:flex-row gap-1">
                    <dt class="min-w-30">
                        <span class="block text-sm text-gray-500 dark:text-neutral-500">Name:</span>
                    </dt>
                    <dd>{{ $school->name }}</dd>
                </dl>
                <dl class="flex flex-col sm:flex-row gap-1">
                    <dt class="min-w-30">
                        <span class="block text-sm text-gray-500 dark:text-neutral-500">Email:</span>
                    </dt>
                    <dd>{{ $school->email }}</dd>
                </dl>
                <dl class="flex flex-col sm:flex-row gap-1">
                    <dt class="min-w-30">
                        <span class="block text-sm text-gray-500 dark:text-neutral-500">Phone:</span>
                    </dt>
                    <dd>{{ $school->phone }}</dd>
                </dl>
                <dl class="flex flex-col sm:flex-row gap-1">
                    <dt class="min-w-30">
                        <span class="block text-sm text-gray-500 dark:text-neutral-500">Address:</span>
                    </dt>
                    <dd>{{ $school->address }}</dd>
                </dl>
                <dl class="flex flex-col sm:flex-row gap-1">
                    <dt class="min-w-30">
                        <span class="block text-sm text-gray-500 dark:text-neutral-500">School Code:</span>
                    </dt>
                    <dd>{{ $school->school_code }}</dd>
                </dl>

            </div>
            <!-- End List -->

            <!-- List -->
            <div class="space-y-4 mb-16">
                <h2>Actvition Details</h2>
                @if ($school->is_active)
                    <dl class="flex flex-col sm:flex-row gap-1">
                        <dt class="min-w-30">
                            <span class="block text-sm text-gray-500 dark:text-neutral-500">Activation status:</span>
                        </dt>
                        <dd>
                            <flux:badge color="green">Active</flux:badge>
                        </dd>
                    </dl>
                    <dl class="flex flex-col sm:flex-row gap-1">
                        <dt class="min-w-30">
                            <span class="block text-sm text-gray-500 dark:text-neutral-500">Activation Code:</span>
                        </dt>
                        <dd>{{ $school->activation_code }}</dd>
                    </dl>
                    <dl class="flex flex-col sm:flex-row gap-1">
                        <dt class="min-w-30">
                            <span class="block text-sm text-gray-500 dark:text-neutral-500">Start Activation:</span>
                        </dt>
                        <dd>{{ $school->subscription_start }}</dd>
                    </dl>
                    <dl class="flex flex-col sm:flex-row gap-1">
                        <dt class="min-w-30">
                            <span class="block text-sm text-gray-500 dark:text-neutral-500">End Activation:</span>
                        </dt>
                        <dd>{{ $school->subscription_end }}</dd>
                    </dl>
                @else
                    <dl class="flex flex-col sm:flex-row gap-1">
                        <dt class="min-w-30">
                            <span class="block text-sm text-gray-500 dark:text-neutral-500">Activation status:</span>
                        </dt>
                        <dd>
                            <flux:badge color="red">Not Active</flux:badge>
                        </dd>
                    </dl>
                    <dl class="flex flex-col sm:flex-row gap-1">
                        <flux:modal.trigger name="active-school-{{ $school->id }}">
                            <flux:button class="w-50" variant="primary" color="green">Active Now</flux:button>
                        </flux:modal.trigger>

                        <flux:modal name="active-school-{{ $school->id }}" class="md:w-96">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Active School</flux:heading>
                                    <flux:text class="mt-2">Make changes to Active School.</flux:text>
                                </div>
                                <flux:radio.group wire:model.live='type' label="Select your type of active">
                                    <flux:radio value="trial_version" label="Trial (6 mouth)" />
                                    <flux:radio value="paid_version" label="Paid" />
                                    <flux:radio value="unlimited_version" label="Unlimited" />
                                </flux:radio.group>
                                <div class="@if ($type != 'paid_version') hidden @endif">
                                    <flux:input wire:model="month" label="Number of mouth" type="number"  />
                                </div>
                                <flux:checkbox.group wire:model='selected_program' label="Programs">
                                    @foreach ($programs as $program)
                                        <flux:checkbox value="{{ $program->id }}" label="{{ $program->name }}" />
                                    @endforeach
                                </flux:checkbox.group>

                                <div class="flex">
                                    <flux:spacer />
                                    <flux:button wire:click="active" variant="primary">Active Now</flux:button>
                                </div>
                            </div>
                        </flux:modal>
                    </dl>
                @endif

            </div>
            <!-- End List -->
        </div>

        <!-- Timeline -->
        <div class="p-5 col-span-3">
            @forelse ($school->activations->reverse() as $active)
                <!-- Item -->
                <div class="group relative flex gap-x-5">
                    <!-- Icon -->
                    <div
                        class="relative group-last:after:hidden after:absolute after:top-8 after:bottom-2 after:start-3 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
                        <div class="relative z-10 size-6 flex justify-center items-center">
                            <flux:icon icon="trophy"></flux:icon>
                        </div>
                    </div>
                    <!-- End Icon -->

                    <!-- Right Content -->
                    <div class="grow pb-8 group-last:pb-0">
                        <h3 class="mb-1 text-xs text-gray-600 dark:text-neutral-400">
                            {{ $active->created_at }}
                            @if (now()->lt($active->created_at->copy()->addMonths($active->subscription_time)))
                                <flux:badge color="green">
                                    Active
                                </flux:badge>
                                @else
                                <flux:badge color="red">
                                    Expire
                                </flux:badge>
                                @endif
                        </h3>

                        <p class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                            @if ($loop->last)
                                This First Activation
                            @else
                                Activation
                            @endif
                        </p>

                        <ul class="list-disc ms-6 mt-3 space-y-1.5">
                            <li class="ps-1 text-sm text-gray-600 dark:text-neutral-400">
                                Code : {{ $active->code }}
                            </li>
                            <li class="ps-1 text-sm text-gray-600 dark:text-neutral-400">
                                Type : {{ $active->type }}
                            </li>
                            <li class="ps-1 text-sm text-gray-600 dark:text-neutral-400">
                                Created By : {{ $active->user->name }}
                            </li>
                            <li class="ps-1 text-sm text-gray-600 dark:text-neutral-400">
                                Subscription Time : {{ $active->subscription_time ? $active->subscription_time . ' month' : 'Unlmited'}}
                            </li>
                            <li class="ps-1 text-sm text-gray-600 dark:text-neutral-400">
                                Programs : @foreach ($active->programs as $program)
                                    <flux:badge>{{ $program->name }}</flux:badge>
                                @endforeach
                            </li>
                            
                    </div>
                    <!-- End Right Content -->
                </div>
                <!-- End Item -->
            @empty
            @endforelse

            <!-- Item -->
            <div class="group relative flex gap-x-5">
                <!-- Icon -->
                <div
                    class="relative group-last:after:hidden after:absolute after:top-8 after:bottom-2 after:start-3 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
                    <div class="relative z-10 size-6 flex justify-center items-center">
                        <flux:icon icon="clipboard-document-check"></flux:icon>
                    </div>
                </div>
                <!-- End Icon -->

                <!-- Right Content -->
                <div class="grow pb-8 group-last:pb-0">
                    <h3 class="mb-1 text-xs text-gray-600 dark:text-neutral-400">
                        {{ $school->created_at }}
                    </h3>

                    <p class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                        date of start with us
                    </p>
                </div>
                <!-- End Right Content -->
            </div>
            <!-- End Item -->
        </div>
        <!-- End Timeline -->
    </div>
</div>
