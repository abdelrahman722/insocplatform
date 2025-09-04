<div class="flex h-full w-full flex-1 flex-col rounded-xl">
    <flux:heading size="xl" level="1">{{ __('Dashbord') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Welcome in Dashboard') }}</flux:subheading>
    <flux:separator variant="subtle" class="mb-3" />
    <!-- الإحصائيات السريعة -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-5 mb-8">
        <!-- إجمالي المدارس -->
        <div class="overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="px-4 py-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 mr-5 rounded-xl border border-neutral-200 dark:border-neutral-700">
                        <flux:icon icon="building-library" color="indigo-600"></flux:icon>
                    </div>
                    <div class="mr-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-bold truncate">
                                Schools
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold ">
                                    {{ $stats['total_schools'] ?? 0 }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- إجمالي المستخدمين -->
        <div class="overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="px-4 py-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 mr-5 rounded-xl border border-neutral-200 dark:border-neutral-700">
                        <flux:icon icon="users" color="indigo-600"></flux:icon>
                    </div>
                    <div class="mr-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium truncate">
                                Users
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold ">
                                    {{ $stats['total_users'] ?? 0 }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!--  إجمالي المدارس المفعلة-->
        <div class="overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="px-4 py-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 mr-5 rounded-xl border border-neutral-200 dark:border-neutral-700">
                        <flux:icon icon="check-circle" color="indigo-600"></flux:icon>
                    </div>
                    <div class="mr-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium truncate">
                                Active School
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold ">
                                    {{ $stats['active_schools'] ?? 0 }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- إجمالي الطلاب -->
        <div class="overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="px-4 py-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 mr-5 rounded-xl border border-neutral-200 dark:border-neutral-700">
                        <flux:icon icon="clipboard-document-check"></flux:icon>
                    </div>
                    <div class="mr-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium truncate">
                                Student
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold ">
                                    {{ $stats['totalStudents'] ?? 0 }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- إجمالي البرامج المفعلة -->
        <div class="overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="px-4 py-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 mr-5 rounded-xl border border-neutral-200 dark:border-neutral-700">
                        <flux:icon icon="clipboard-document-check"></flux:icon>
                    </div>
                    <div class="mr-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium truncate">
                                Active Programs
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold ">
                                    {{ $stats['active_programs'] ?? 0 }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-8">
        <div class=" overflow-hidden shadow rounded-lg col-span-3 border border-neutral-200 dark:border-neutral-700">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">last school add</h3>
            </div>
            <div class="overflow-x-auto p-3">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Active Type</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Created At</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Student Count</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($recentActivations as $activation)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                    {{ $activation->school->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                    {{ ucfirst($activation->type) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $activation->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $activation->school->students->count() }}
                                    </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">لا توجد
                                    تفعيلات حديثة.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div>11</div>
    </div>
</div>
