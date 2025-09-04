<div class="max-w-full font-sans">
    <!-- العنوان -->
    <flux:heading size="xl" level="1">{{ __('Guardian Dashboard') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        <div class="grid grid-cols-2 gap-5 sm:grid-cols-2 lg:grid-cols-2">
            {{ __('hi ' . Auth::user()->name . ', How Are You Today.') }}
        </div>
    </flux:subheading>
    <flux:separator variant="subtle" />

     <div class="grid grid-cols-1 gap-6 mt-6 lg:grid-cols-3">

        <div class="lg:col-span-2 space-y-6">
            <!-- بطاقة الأبناء (Accordion) -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-green-600 px-6 py-4 text-white">
                    <h2 class="text-lg font-semibold">Student</h2>
                </div>
                <div class="p-6">
                    @if($students->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400">No Student Yat</p>
                    @else
                        <div class="space-y-4">
                            @foreach($students as $student)
                                <div x-data="{ open: false }" class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                    <!-- رأس القائمة المطوية -->
                                    <button @click="open = !open" class="w-full px-6 py-4 text-left bg-gray-50 dark:bg-gray-700 flex justify-between items-center hover:bg-gray-100 dark:hover:bg-gray-600 transition"
                                    >
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $student->user->name }}</span>
                                        <span x-show="!open" class="text-gray-500 dark:text-gray-400">Show Details</span>
                                        <span x-show="open" x-cloak class="text-gray-500 dark:text-gray-400">Hide Details</span>
                                        <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        <svg x-show="open" x-cloak class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        </svg>
                                    </button>

                                    <!-- محتوى القائمة المطوية -->
                                    <div x-show="open" x-collapse x-cloak class="p-6 pt-0 border-t border-gray-200 dark:border-gray-700">
                                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 pt-3">
                                            <div>
                                                <strong class="text-gray-700 dark:text-gray-300">Code:</strong>
                                                <span class="ml-2 text-gray-900 dark:text-white">{{ $student->code }}</span>
                                            </div>
                                            <div>
                                                <strong class="text-gray-700 dark:text-gray-300">Phone:</strong>
                                                <span class="ml-2 text-gray-900 dark:text-white">{{ $student->phone }}</span>
                                            </div>
                                            <div>
                                                <strong class="text-gray-700 dark:text-gray-300">Email:</strong>
                                                <span class="ml-2 text-gray-900 dark:text-white">{{ $student->user->email }}</span>
                                            </div>
                                            <div>
                                                <strong class="text-gray-700 dark:text-gray-300">Class:</strong>
                                                <span class="ml-2 text-gray-900 dark:text-white">{{ optional($student->semester)->name ?? 'unone' }}</span>
                                            </div>
                                        </div>

                                        <!-- المواد (مخصصة للطالب) -->
                                        <div class="mt-6">
                                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Sections</h4>
                                            <div class="mt-2 overflow-x-auto">
                                                <table class="min-w-full text-sm border border-gray-300 dark:border-gray-600 rounded">
                                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                                        <tr>
                                                            <th class="px-3 py-2 text-left">Section</th>
                                                            <th class="px-3 py-2 text-left">Teacher</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                        @foreach($student->semester->sections ?? [] as $subject)
                                                            <tr>
                                                                <td class="px-3 py-2 font-medium">{{ $subject->name }}</td>
                                                                <td class="px-3 py-2">{{ optional($subject->teacher->user)->name ?? 'غير محدد' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- المواعيد القادمة -->
            <livewire:guardian.upcoming-meeting />
        </div>

        <!-- بطاقة المدرسة -->
        <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-blue-600 px-6 py-4 text-white">
                <h2 class="text-lg font-semibold">School Information</h2>
            </div>
            <div class="p-6 space-y-4">
                @if ($school)
                    <div class="flex items-center">
                        <flux:icon icon="school" class="w-5 h-5 text-blue-500 ltr:mr-3 rtl:ml-3" />
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $school->name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $school->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <flux:icon icon="phone" class="w-5 h-5 text-blue-500 ltr:mr-3 rtl:ml-3" />
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $school->phone }}</span>
                    </div>
                    <div class="flex items-start">
                        <flux:icon icon="map-pin-check-inside" class="w-5 h-5 text-blue-500 ltr:mr-3 rtl:ml-3" />
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $school->address }}</span>
                    </div>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">No Information To View</p>
                @endif
            </div>
        </div>
    </div>
</div>