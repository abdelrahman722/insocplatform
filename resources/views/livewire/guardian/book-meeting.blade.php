<div class="max-w-full mx-auto font-sans">
    <!-- العنوان -->
    <flux:heading size="xl" level="1">{{ __('Book Meeting') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
    </flux:subheading>
    <flux:separator variant="subtle" />

    <div class="space-x-2 pt-3">
        <form wire:submit="book">
            <div class="grid grid-cols-3 gap-6">
                <div class="col space-y-6">
                    <!-- اختيار المدرس -->
                    <flux:select wire:model.live="teacherId" placeholder="Choose Teacher..." label="Teacher">
                        @foreach ($teachers as $teacher)
                            <flux:select.option value="{{ $teacher->id }}">{{ $teacher->user->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>

                    <!-- اختيار الطالب (اختياري) -->
                    <flux:select wire:model.live="studentId" placeholder="Choose Student..." label="Student">
                        @foreach ($students as $student)
                            <flux:select.option value="{{ $student->id }}">{{ $student->user->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>

                    <!-- سبب الاجتماع -->
                    <flux:textarea wire:model="purpose" label="Reason for meeting" />

                    <!-- زر الحجز -->
                    <flux:button wire:loading.attr="disabled" type="submit">
                        <span wire:loading.remove>حجز الموعد</span>
                        <span wire:loading>جاري الحجز...</span>
                    </flux:button>

                </div>
                <div class="col-span-2 space-y-6">
                    <!-- التقويم الشهري -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden" @if($teacherId == '') hidden @endif>
                        <!-- رأس التقويم -->
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 flex justify-between items-center">
                            <button type="button" wire:click="previousMonth"
                                class="p-1 hover:bg-gray-200 dark:hover:bg-gray-600 rounded">
                                ←
                            </button>
                            <h3 class="text-lg font-medium">{{ $monthName }}</h3>
                            <button type="button" wire:click="nextMonth"
                                class="p-1 hover:bg-gray-200 dark:hover:bg-gray-600 rounded">
                                →
                            </button>
                        </div>

                        <!-- أيام الأسبوع -->
                        <div
                            class="grid grid-cols-7 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-xs font-medium text-gray-500 dark:text-gray-400">
                            <div class="p-2 text-center">Sunday</div>
                            <div class="p-2 text-center">Monday</div>
                            <div class="p-2 text-center">Tuesday</div>
                            <div class="p-2 text-center">Wednesday</div>
                            <div class="p-2 text-center">Thursday</div>
                            <div class="p-2 text-center">Friday</div>
                            <div class="p-2 text-center">Saturday</div>
                        </div>

                        <!-- أيام الشهر -->
                        <div class="grid grid-cols-7 divide-x divide-y divide-gray-200 dark:divide-gray-700 min-h-64">
                            @foreach ($monthlySlots as $day)
                                <div class="min-h-20 p-1">
                                    <!-- رقم اليوم -->
                                    <div class="flex justify-center mb-1">
                                        <span class="w-8 h-8 flex items-center justify-center text-sm
                                            {{ $day['is_today'] ? 'bg-blue-500 text-white rounded-full' : '' }}
                                            {{ !$day['is_current_month'] ? 'text-gray-400 dark:text-gray-500' : '' }}
                                            {{ $day['is_past'] ? 'text-red-500' : '' }}">
                                            {{ $day['day'] }}
                                        </span>
                                    </div>

                                    <!-- الفترات -->
                                    <div class="space-y-1">
                                        @if ($day['is_past'])
                                            <div class="text-xs text-center text-red-500">NotAvailable</div>
                                        @elseif(empty($day['slots']))
                                            <div class="text-xs text-center text-gray-500">-</div>
                                        @else
                                            @foreach ($day['slots'] as $slot)
                                                @if ($slot['is_available'])
                                                    <button type="button" wire:click="selectSlot('{{ $day['date'] }}', {{ $slot['id'] }})" class="p-1 text-xs rounded border text-center w-full
                                                {{ $selectedDate == $day['date'] && $selectedSlotId == $slot['id']
                                                    ? 'bg-blue-600 text-white border-blue-700'
                                                    : 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 border-green-200 dark:border-green-800 hover:bg-green-200 dark:hover:bg-green-800/50' }}">
                                                        {{ substr($slot['start_time'], 0, 8) }} -
                                                        {{ substr($slot['end_time'], 0, 5) }}
                                                    </button>
                                                @else
                                                    <div class="text-center p-1 text-xs bg-gray-100 dark:bg-gray-700 w-full text-gray-500 dark:text-gray-400 rounded line-through">
                                                        {{ substr($slot['start_time'], 0, 5) }} -
                                                        {{ substr($slot['end_time'], 0, 5) }}
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
