<div class="max-w-full mx-auto font-sans">
    <flux:heading size="xl" level="1" class="mb-6">{{ __('Set Meeting Time') }}</flux:heading>
    <flux:separator variant="subtle" />

    <div class="mt-3 grid grid-cols-2 gap-6">
        <div class="col border rounded-2xl border-gray-500">
            <form wire:submit="addSlot" class="space-y-6 p-6">

                <flux:select wire:model="dayOfWeek" placeholder="Choose Day..." label="Day">
                    @foreach($days as $key => $day)
                        <flux:select.option value="{{ $key }}">{{ $day }}</flux:select.option>
                    @endforeach
                </flux:select>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">from</label>
                        <input type="time" wire:model="startTime" class="appearance-none w-full ps-3 pe-3 block h-10 py-2 text-base sm:text-sm rounded-lg shadow-xs bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 dark:text-zinc-300 disabled:text-zinc-500 dark:disabled:text-zinc-400 has-[option.placeholder:checked]:text-zinc-400 dark:has-[option.placeholder:checked]:text-zinc-400 dark:[&>option]:bg-zinc-700 dark:[&>option]:text-white disabled:shadow-none border border-zinc-200 border-b-zinc-300/80 dark:border-white/10">
                        @error('startTime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">to</label>
                        <input type="time" wire:model="endTime" class="appearance-none w-full ps-3 pe-3 block h-10 py-2 text-base sm:text-sm rounded-lg shadow-xs bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 dark:text-zinc-300 disabled:text-zinc-500 dark:disabled:text-zinc-400 has-[option.placeholder:checked]:text-zinc-400 dark:has-[option.placeholder:checked]:text-zinc-400 dark:[&>option]:bg-zinc-700 dark:[&>option]:text-white disabled:shadow-none border border-zinc-200 border-b-zinc-300/80 dark:border-white/10">
                        @error('endTime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    
                    

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        إضافة الفترة
                    </button>
                </div>
            </form>
        </div>
        <div class="col bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- قائمة الفترات الحالية -->
            <div class="bg-green-600 px-6 py-4 text-white">
                <h3 class="text-lg font-semibold">Time Available</h3>
            </div>
            <div class="p-4">
                @if($availableSlots->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">not Meeting Time Add yat</p>
                @else
                    <div class="space-y-2">
                        @foreach($availableSlots as $slot)
                            <div class="flex justify-between items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $days[$slot->day_of_week] }}</span>
                                <span class="text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                </span>
                                <button wire:click="deleteSlot({{ $slot->id }})" class="text-red-500 hover:text-red-700 cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>