<div class="max-w-2xl mx-auto my-5">
    @if (session()->has('message'))
        <div class="rounded-md bg-green-50 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('message') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="submit" class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            {{ __('طلب تفعيل منصة InSoc') }}
        </h2>

        @if ($errors->any())
            <div class="rounded-md bg-red-50 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            {{ __('يرجى تصحيح الأخطاء التالية:') }}
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- اسم مقدم الطلب -->
            <div class="md:col-span-2">
                <label for="requester_name" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('اسم مقدم الطلب') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       wire:model="requester_name"
                       id="requester_name"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('requester_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- رقم الهاتف -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('رقم الهاتف') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       wire:model="phone"
                       id="phone"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- البريد الإلكتروني -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('البريد الإلكتروني') }} <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       wire:model="email"
                       id="email"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- اسم المدرسة -->
            <div class="md:col-span-2">
                <label for="school_name" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('اسم المدرسة') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       wire:model="school_name"
                       id="school_name"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('school_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- البرامج المطلوبة -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('البرامج المطلوبة') }} <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-2">
                    @foreach($availablePrograms as $program)
                        <div class="flex items-center">
                            <input id="program_{{ $program->code }}" 
                                   wire:model="programs"
                                   type="checkbox" 
                                   value="{{ $program->code }}"
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="program_{{ $program->code }}" class="mr-3 block text-sm text-gray-700">
                                <div class="flex items-center">
                                    <i class="{{ $program->icon }} mr-2 text-indigo-600"></i>
                                    {{ $program->name }}
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $program->description }}</p>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('programs') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- ملاحظات إضافية -->
            <div class="md:col-span-2">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('ملاحظات إضافية') }} <span class="text-gray-500">({{ __('اختياري') }})</span>
                </label>
                <textarea wire:model="notes"
                          id="notes"
                          rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8">
            <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-paper-plane ml-2"></i>
                {{ __('إرسال طلب التفعيل') }}
            </button>
        </div>
    </form>
</div>