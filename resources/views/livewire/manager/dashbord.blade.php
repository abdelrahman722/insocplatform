<div class="max-w-6xl mx-auto">
    <!-- العنوان -->
    <flux:heading size="xl" level="1">{{ __('School Dashboard') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">Welcome back, {{ auth()->user()->name }}. Here's what's happening at your school.</flux:subheading>
    <flux:separator variant="subtle" />

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mt-6">
        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Quick Actions</h3>
                <hr class="my-3 border-gray-200 dark:border-gray-700">
                <div class="space-y-2">
                    <a href="{{ route('manager.students.create') }}" class="block text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">➕ Add New Student</a>
                    <a href="{{ route('manager.guardians.create') }}" class="block text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">➕ Add New Parent</a>
                    <a href="{{ route('manager.import') }}" class="block text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">📥 Import from Excel</a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700 space-x-1.5">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">School Info</h3>
                <hr class="my-3 border-gray-200 dark:border-gray-700">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <div class="space-x-1.5 mb-1">
                        <span class="font-bold">School:</span>
                        <span>{{ auth()->user()->school->name ?? 'N/A' }}</span>
                    </div>
                    <div class="space-x-1.5 mb-1">
                        <span class="font-bold">Manager:</span>
                        <span>{{ auth()->user()->name ?? 'N/A' }}</span>
                    </div>
                    <div class="space-x-1.5 mb-1">
                        <span class="font-bold">Since:</span>
                        <span>{{ auth()->user()->created_at->format('M Y') ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">School Actviation</h3>
                <hr class="my-3 border-gray-200 dark:border-gray-700">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    @if($school->is_active)
                    <div class="space-x-1.5 mb-2">
                        <span class="font-bold">State:</span>
                        <span class="bg-green-500 text-white p-1 rounded-sm">Active</span>
                    </div>
                    <div class="space-x-1.5 mb-1">
                        <span class="font-bold">Strat:</span>
                        <span>{{ $school->subscription_start->format('d M Y') }}</span>
                    </div>
                    <div class="space-x-1.5 mb-1">
                        <span class="font-bold">End:</span>
                        <span>{{ $school->subscription_end->format('d M Y') }}</span>
                    </div>
                    @else
                        <div class="space-x-1.5 mb-2">
                            <span class="font-bold">State:</span>
                            <span class="bg-red-500 text-white p-1 rounded-sm">Not Active</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- إحصائيات سريعة -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <!-- الطلاب -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Students</dt>
                                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $totalStudents }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- المدرسين -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m5 10v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5m12-5v5a2 2 0 01-2 2H9a2 2 0 01-2-2v-5"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Teachers</dt>
                                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $totalTeachers }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- أولياء الأمور -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Guardians</dt>
                                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $totalGuardians }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- أحدث الطلاب -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Students</h2>
                </div>
                <div class="p-6">
                    @if($recentStudents->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400">No students added yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Code</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Semester</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Added</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentStudents as $student)
                                        <tr>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $student->user->name }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $student->code }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ optional($student->semester)->name ?? 'N/A' }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $student->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- أحدث أولياء الأمور -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Guardians</h2>
                </div>
                <div class="p-6">
                    @if($recentGuardians->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400">No guardians added yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Phone</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Added</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentGuardians as $guardian)
                                        <tr>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $guardian->user->name }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $guardian->phone }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $guardian->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>