<div class="p-6 w-full mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg">
    <flux:heading size="xl" level="2" class="text-center">Activation Status</flux:heading>
    <flux:separator variant="subtle" class="my-4" />

    @if ($status === 'active' && $activation)
        <div class="text-center py-6">
            <flux:icon icon="check-circle" class="w-12 h-12 text-green-500 mx-auto" />
            <flux:heading size="base" class="text-green-700 dark:text-green-400 mt-2">Active</flux:heading>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                Active to: {{ $activation->created_at->addMonths($activation->subscription_time)->format('Y-m-d') }}
            </p>
        </div>

    @elseif ($status === 'expired')
        <div class="text-center py-6">
            <flux:icon icon="exclamation-circle" class="w-12 h-12 text-red-500 mx-auto" />
            <flux:heading size="base" class="text-red-700 dark:text-red-400 mt-2">expired</flux:heading>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Active is Expired</p>
            <div class="mt-4">
                <flux:modal.trigger name="request-active">
                    <flux:button variant="primary">
                        Request Active
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>

    @elseif ($status === 'requested')
        <div class="text-center py-6">
            <flux:icon icon="clock" class="w-12 h-12 text-yellow-500 mx-auto" />
            <flux:heading size="base" class="text-yellow-700 dark:text-yellow-400 mt-2">your request has been sended</flux:heading>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Please wait for your request to be responded to.</p>
        </div>

    @elseif ($status === 'no_active')
        <div class="text-center py-6">
            <flux:icon icon="exclamation-triangle" class="w-12 h-12 text-orange-500 mx-auto" />
            <flux:heading size="base" class="text-orange-700 dark:text-orange-400 mt-2">There is no active activation</flux:heading>
            <div class="mt-4">
                <flux:modal.trigger name="request-active">
                    <flux:button variant="primary">
                        Request Active
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>
    @else
        <div class="text-center py-6">
            <flux:icon.loading class="w-10 h-10 mx-auto" />
            <p class="mt-2 text-gray-600">جاري التحميل...</p>
        </div>
    @endif

    <flux:modal name="request-active" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Update profile</flux:heading>
                <flux:text class="mt-2">Make changes to your personal details.</flux:text>
            </div>
            <flux:input label="Phone" placeholder="Your phone" wire:model="phone" />

            <flux:checkbox.group wire:model='selected_program' label="Programs">
                @foreach ($programs as $program)
                    <flux:checkbox value="{{ $program->code }}" label="{{ $program->name }}" />
                @endforeach
                <flux:error name="selected_program" />
            </flux:checkbox.group>

            <div class="flex">
                <flux:spacer />
                <flux:button  wire:click="requestActivation" variant="primary">Save changes</flux:button>
            </div>
        </div>
    </flux:modal>   
</div>