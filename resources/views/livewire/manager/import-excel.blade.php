<div class=" max-w-6xl mx-auto font-sans">
    <!-- العنوان -->
    <flux:heading size="xl" level="1">{{ __('Excel Import') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        {{ __('mport students, guardians, and teachers data from an Excel file.') }}
    </flux:subheading>
    <flux:separator variant="subtle" />
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mt-6">
        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Progress Steps -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 font-medium text-sm">
                            1
                        </span>
                        <span class="ml-3 font-medium text-gray-700 dark:text-gray-300">Upload Excel File</span>
                    </div>
                    <div class="flex items-center">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full {{ $step == 2 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }} font-medium text-sm">
                            2
                        </span>
                        <span class="ml-3 font-medium {{ $step == 2 ? 'text-gray-700 dark:text-gray-300' : 'text-gray-500 dark:text-gray-400' }}">Review & Save Data</span>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">File Instructions</h3>
                <hr class="my-3 border-gray-200 dark:border-gray-700">
                <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1 list-disc list-inside">
                    <li>File must have 3 sheets: <strong class="text-gray-900 dark:text-white">Students</strong>, <strong class="text-gray-900 dark:text-white">Guardians</strong>, <strong class="text-gray-900 dark:text-white">Teachers</strong>.</li>
                    <li>Include headers in the first row.</li>
                    <li>Use the exact column names as shown.</li>
                    <li>All fields are required.</li>
                </ul>
            </div>

            <!-- Download Template -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Download Template</h3>
                <hr class="my-3 border-gray-200 dark:border-gray-700">
                <a href="{{ asset('templates/import-template.xlsx') }}" class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    import-template.xlsx
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            @if ($step == 1)
                <!-- Step 1: Upload -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Upload Your Excel File</h2>
                    </div>
                    <div class="p-6">

                        <!-- Excel Preview -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Students Sheet</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Required
                                </span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-xs border border-gray-300 dark:border-gray-600 rounded">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-3 py-2 text-left">Name</th>
                                            <th class="px-3 py-2 text-left">Email</th>
                                            <th class="px-3 py-2 text-left">Code</th>
                                            <th class="px-3 py-2 text-left">Phone</th>
                                            <th class="px-3 py-2 text-left">Semester</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr>
                                            <td class="px-3 py-2">Ahmed Ali</td>
                                            <td class="px-3 py-2">ahmed@example.com</td>
                                            <td class="px-3 py-2">STU001</td>
                                            <td class="px-3 py-2">+123456789</td>
                                            <td class="px-3 py-2">Grade 1</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Guardians Sheet -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Guardians Sheet</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Required
                                </span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-xs border border-gray-300 dark:border-gray-600 rounded">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-3 py-2 text-left">Name</th>
                                            <th class="px-3 py-2 text-left">Email</th>
                                            <th class="px-3 py-2 text-left">Phone</th>
                                            <th class="px-3 py-2 text-left">Student Codes</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr>
                                            <td class="px-3 py-2">Mohamed Taha</td>
                                            <td class="px-3 py-2">mohamed@example.com</td>
                                            <td class="px-3 py-2">+1122334455</td>
                                            <td class="px-3 py-2">STU001, STU002</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Teachers Sheet -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Teachers Sheet</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Required
                                </span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-xs border border-gray-300 dark:border-gray-600 rounded">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-3 py-2 text-left">Name</th>
                                            <th class="px-3 py-2 text-left">Email</th>
                                            <th class="px-3 py-2 text-left">Phone</th>
                                            <th class="px-3 py-2 text-left">semesters</th>
                                            <th class="px-3 py-2 text-left">section</th>
                                            <th class="px-3 py-2 text-left">job_number</th>
                                            <th class="px-3 py-2 text-left">job_title</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr>
                                            <td class="px-3 py-2">Laila Hassan</td>
                                            <td class="px-3 py-2">laila@example.com</td>
                                            <td class="px-3 py-2">+5566778899</td>
                                            <td class="px-3 py-2">Grade 1, grade 2</td>
                                            <td class="px-3 py-2">Math</td>
                                            <td class="px-3 py-2">jp001</td>
                                            <td class="px-3 py-2">Math Teacher</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Upload Field -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Excel File</label>
                            <input type="file" wire:model="file" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 text-sm dark:bg-gray-700 dark:text-white">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload your .xlsx or .csv file</p>
                            <flux:error name="file" />
                        </div>

                        <!-- Validation Errors -->
                        @if (!empty($errors))
                            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
                                <h4 class="text-sm font-semibold text-red-800 dark:text-red-200 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Validation Errors
                                </h4>
                                <ul class="mt-1.5 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                    @foreach ($errors as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="flex justify-end mt-6">
                            <button wire:click="next" wire:loading.attr="disabled" type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                                <span wire:loading.remove wire:target="next">Next</span>
                                <span wire:loading wire:target="next">Loading...</span>
                            </button>
                        </div>
                    </div>
                </div>

            @elseif ($step == 2)
                <!-- Step 2: Review Data -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Review Your Data</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Please review the data below before saving.</p>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Students Table -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Students</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm border border-gray-300 dark:border-gray-600 rounded">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-3 py-2 text-left">Name</th>
                                            <th class="px-3 py-2 text-left">Email</th>
                                            <th class="px-3 py-2 text-left">Code</th>
                                            <th class="px-3 py-2 text-left">Semester</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($students as $student)
                                            <tr>
                                                <td class="px-3 py-2">{{ $student['name'] }}</td>
                                                <td class="px-3 py-2">{{ $student['email'] }}</td>
                                                <td class="px-3 py-2">{{ $student['code'] }}</td>
                                                <td class="px-3 py-2">{{ $student['semester'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Guardians Table -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Guardians</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm border border-gray-300 dark:border-gray-600 rounded">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-3 py-2 text-left">Name</th>
                                            <th class="px-3 py-2 text-left">Email</th>
                                            <th class="px-3 py-2 text-left">Student Codes</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($guardians as $guardian)
                                            <tr>
                                                <td class="px-3 py-2">{{ $guardian['name'] }}</td>
                                                <td class="px-3 py-2">{{ $guardian['email'] }}</td>
                                                <td class="px-3 py-2">{{ $guardian['student_codes'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Teachers Table -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Teachers</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm border border-gray-300 dark:border-gray-600 rounded">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-3 py-2 text-left">Name</th>
                                            <th class="px-3 py-2 text-left">Email</th>
                                            <th class="px-3 py-2 text-left">Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($teachers as $teacher)
                                            <tr>
                                                <td class="px-3 py-2">{{ $teacher['name'] }}</td>
                                                <td class="px-3 py-2">{{ $teacher['email'] }}</td>
                                                <td class="px-3 py-2">{{ $teacher['phone'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="flex justify-between mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button wire:loading.remove wire:click="previous" type="button" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-lg transition dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white">
                                Previous
                            </button>
                            <button wire:loading.remove wire:click="save" type="button" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                                Save Data
                            </button>
                            <flux:icon.loading wire:loading wire:target="save" />
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>