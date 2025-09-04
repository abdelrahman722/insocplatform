<div class="flex">
    <div class="h-full viewBox fixed top-0 bottom-0 right-1/5 left-1/5">
        @if ($selectedConversation)
            <!-- نافذة الرسائل -->
            <div class="fixed top-2/12 right-1/5 left-1/5 h-8/12 overflow-y-auto" style="scrollbar-width: none; -ms-overflow-style: none;">
                <div class="flex flex-col space-y-3">
                    @foreach(array_reverse($selectedConversation['messages']) as $message)
                        <div class="flex {{ $message['sender_id'] == Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="
                                max-w-xs px-4 py-2 rounded-lg
                                {{ $message['sender_id'] == Auth::id() 
                                    ? 'bg-blue-600 text-white rounded-br-none' 
                                    : 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-bl-none shadow'
                                }}
                            ">
                                <p class="text-sm">{{ $message['body'] }}</p>
                                <span class="text-xs opacity-70 mt-1 block">
                                    {{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}
                                    @if($message['read_at'])
                                        <span class="text-green-300">✓✓</span>
                                    @elseif($message['sender_id'] == Auth::id())
                                        <span>✓</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- حقل الإرسال -->
            <div class="fixed bottom-0 right-1/5 left-1/5 px-20 mb-7">
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="flex items-end space-x-2">
                        <flux:input wire:model.live="messagebody" placeholder="Message" />

                        <!-- زر إرفاق ملف -->
                        <label class="p-2 bg-gray-200 dark:bg-gray-700 rounded-lg cursor-pointer">
                            <flux:icon icon="paper-clip" class="w-6 h-6 text-gray-600 dark:text-gray-400" />
                            <input type="file" wire:model="attachment" class="hidden">
                        </label>
                        <!-- زر الإرسال -->
                        <flux:button icon="paper-airplane" wire:click="sendMessage" wire:loading.attr="disabled" class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition w-6 h-6 cursor-pointer" />
                    </div>

                    <!-- عرض الملف المرفق -->
                    @if($attachment)
                        <div class="mt-2 p-2 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-between">
                            <span class="text-sm truncate">{{ $attachment->getClientOriginalName() }}</span>
                            <button wire:click="$set('attachment', null)" class="text-red-500 ml-2">
                                ✕
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="flex-1 flex items-center justify-center text-gray-500 dark:text-gray-400 h-full">
                Select To Start Chat
            </div>
        @endif
    </div>

    <!-- قائمة المحادثات -->
    <flux:sidebar class="bg-zinc-50 dark:bg-zinc-900 border-l rtl:border-l-0 rtl:border-r border-zinc-200 dark:border-zinc-700 min-h-screen h-screen fixed top-0 bottom-0 {{ in_array(app()->getLocale(), ['ar', 'he']) ? 'left-0' : 'right-0' }}">
        <flux:brand href="#" name="Conversations" class="px-2 hidden dark:flex" />
        <flux:input variant="filled" placeholder="Search..." icon="magnifying-glass" wire:model.live="search" />
        <div variant="outline" class="overflow-auto scroll-smooth" style="scrollbar-width: none; -ms-overflow-style: none;">
            @foreach($conversations as $item)
                <flux:profile 
                    :name="$item['name']" 
                    :initials="$item['avatar']" 
                    icon:trailing=""
                    wire:click="selectConversation(
                        {{ $item['type'] === 'existing' ? $item['id'] : 'null' }}, 
                        {{ $item['type'] === 'new' ? $item['other_id'] : 'null' }}
                    )"
                />
            @endforeach
        </div>
    </flux:sidebar>
</div>
