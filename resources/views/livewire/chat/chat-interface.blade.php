<div>
    {{-- الشات --}}
    <div class="h-full viewBox fixed top-0 bottom-0 right-1/5 left-1/5">
        @if ($selectedConversation)
            <!-- نافذة الرسائل -->
            <div id="chatWindow" class="fixed top-2/12 right-1/5 left-1/5 h-8/12 overflow-y-auto" style="scrollbar-width: none; -ms-overflow-style: none;" wire:key="conversation-{{ $selectedConversation->id }}-{{ $selectedConversation->refresh_key ?? 'initial' }}">
                <div class="flex flex-col space-y-3">
                    @foreach($selectedConversation->messages as $message)
                        <livewire:chat.message-chat 
                            :message="$message" 
                            wire:key="message-{{ $message->id }}-{{ $message->read_at ? 'read' : 'unread' }}"
                        />
                    @endforeach
                </div>
            </div>

            <!-- حقل الإرسال -->
            <div class="fixed bottom-0 right-1/5 left-1/5 px-20 mb-7">
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="flex items-end space-x-2">
                        <flux:input wire:model.defer="messageBody" wire:keydown.enter="sendMessage" placeholder="Message" autofocus />

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
            @foreach($conversationsUser as $user)
                <flux:profile 
                    :name="$user->user->name" 
                    icon:trailing=""
                    wire:click="selectConversation({{ $user->user->id }})"
                    class="w-full m-2 {{ $user->user->id == $selectedConversation?->user_id_1 || $user->user->id == $selectedConversation?->user_id_2 ? 'bg-gray-800' : '' }}"
                />
            @endforeach
        </div>
    </flux:sidebar>

    <script>
        // 1. إضافة متغير لتتبع آخر وقت تم فيه التمرير
        let lastScrollTime = 0;
        const MIN_SCROLL_INTERVAL = 200; // 200ms بين كل تمرير
        
        // 1. دالة التمرير الأساسية (معدلة)
        function safeScrollToBottom() {
            // تجنب التمرير المتكرر في فترة قصيرة
            const now = Date.now();
            if (now - lastScrollTime < MIN_SCROLL_INTERVAL) {
                return false;
            }
            
            const container = document.getElementById('chatWindow');
            if (!container) {
                console.log('⚠️ السكربت: chatWindow غير موجود في DOM');
                return false;
            }
            
            console.log('✅ السكربت: chatWindow موجود في DOM');
            console.log('الارتفاع الكلي:', container.scrollHeight);
            console.log('الارتفاع المرئي:', container.clientHeight);
            
            // تأكد أن المحتوى أكبر من ارتفاع العنصر
            if (container.scrollHeight <= container.clientHeight) {
                console.log('⚠️ السكربت: لا يوجد محتوى كافٍ للتمرير');
                return false;
            }
            
            // تمرير إلى الأسفل
            container.scrollTop = container.scrollHeight;
            lastScrollTime = Date.now(); // تحديث وقت آخر تمرير
            return true;
        }

        // 2. دالة المحاولات الذكية (معدلة)
        function tryScrollWithDelay(attempt = 1, source = 'unknown') {
            
            if (safeScrollToBottom()) {
                return;
            }
            
            if (attempt >= 20) {
                return;
            }
            
            // تأخير متزايد (50ms, 100ms, 150ms...)
            setTimeout(() => tryScrollWithDelay(attempt + 1, source), attempt * 50);
        }

        // 3. دالة التمرير الفورية (للحالات الحرجة)
        function forceScroll() {
            setTimeout(() => tryScrollWithDelay(1, 'force'), 50);
        }

        // 4. تأكد من أن Livewire جاهز
        function waitForLivewire() {
            if (typeof Livewire === 'undefined') {
                setTimeout(waitForLivewire, 100);
                return;
            }
            
            // 4.1 تمرير عند اختيار محادثة جديدة
            Livewire.hook('message.processed', (message, component) => {
                
                // تحقق إذا كانت الرسالة تتعلق بـ selectConversation
                const isSelectConversation = message.updateQueue?.some(u => 
                    u.payload?.method === 'call' && 
                    u.payload?.params?.[0] === 'selectConversation'
                );
                
                if (isSelectConversation) {
                    setTimeout(() => tryScrollWithDelay(1, 'selectConversation'), 100);
                }
            });
            
            // 4.2 تمرير عند استقبال حدث scroll-chat
            Livewire.on('scroll-chat', (data) => {
                setTimeout(() => tryScrollWithDelay(1, 'scroll-chat'), 50);
            });
            
            // 4.3 تعطيل التمرير عند تحديث العنصر (لتجنب التكرار)
            // تم إزالة هذا لتجنب التمرير المكرر
            // Livewire.hook('element.updated', (el, component) => { ... });
            
            // 4.4 تمرير عند التحميل الأولي (للمحادثات المفتوحة)
            setTimeout(() => {
                if (document.getElementById('chatWindow')) {
                    tryScrollWithDelay(1, 'initial');
                }
            }, 500);
        }

        // 5. ابدأ المراقبة
        waitForLivewire();

        // 6. مراقبة DOM للتأكد من وجود العنصر (معدلة)
        const observer = new MutationObserver((mutations) => {
            mutations.forEach(mutation => {
                if (mutation.addedNodes) {
                    for (let node of mutation.addedNodes) {
                        if (node.nodeType === 1 && node.id === 'chatWindow') {
                            // تجنب التمرير المكرر من هنا
                            setTimeout(() => {
                                if (Date.now() - lastScrollTime > 500) {
                                    tryScrollWithDelay(1, 'DOM mutation');
                                }
                            }, 50);
                        }
                    }
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

        // 7. واجهة خارجية للتحقيق
        window.debugChatScroll = {
            scrollToBottom: forceScroll,
            checkElement: () => {
                const container = document.getElementById('chatWindow');
                console.log('chatWindow موجود؟', !!container);
                if (container) {
                    console.log('scrollHeight:', container.scrollHeight);
                    console.log('clientHeight:', container.clientHeight);
                    console.log('scrollTop:', container.scrollTop);
                }
            }
        };
        
    </script>
</div>