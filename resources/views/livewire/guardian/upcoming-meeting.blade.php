<div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="bg-purple-600 px-6 py-4 text-white">
        <h2 class="text-lg font-semibold">Coming Meeting</h2>
    </div>
    <div class="p-6">
        @if($meetings->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">no meeting coming</p>
        @else
            <div class="space-y-4">
                @foreach($meetings as $appointment)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-white">
                                    Meeting With: {{ $appointment->availableSlot->teacher->user->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Student: {{ $appointment->student?->user->name ?? 'Son' }}
                                </p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                {{ $appointment->status === 'confirmed' ? 'conferm' : 'padding' }}
                            </span>
                        </div>

                        <div class="mt-3 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <strong class="text-gray-700 dark:text-gray-300">date:</strong>
                                <span class="ml-1 text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($appointment->scheduled_date)->format('l, M j, Y') }}
                                </span>
                            </div>
                            <div>
                                <strong class="text-gray-700 dark:text-gray-300">time:</strong>
                                <span class="ml-1 text-gray-900 dark:text-white">
                                    {{ $appointment->availableSlot->start_time }}
                                    -
                                    {{ $appointment->availableSlot->end_time }}
                                </span>
                            </div>
                        </div>

                        @if($appointment->purpose)
                            <div class="mt-3">
                                <strong class="text-gray-700 dark:text-gray-300">السبب:</strong>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ Str::limit($appointment->purpose, 100) }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>