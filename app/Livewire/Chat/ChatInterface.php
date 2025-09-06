<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Component;
use App\Models\Conversation;
use App\Events\SendMessageEvent;
use App\Events\MessageReadedEvent;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class ChatInterface extends Component
{
    use WireToast;
    public $user;
    public $conversationsUser, $selectedConversation, $search = '';
    public $messageBody, $attachment, $reciverId;
    
    /**
     * التقاط الحدث الخاص بالشات
     *
     * @return array
     */
    public function getListeners()
    {
        return [
            "echo-private:chat." . $this->user->id . ",SendMessageEvent" => 'newChatMessage',
            "echo-private:chatReaded." . $this->user->id . ",MessageReadedEvent" => 'chatReadUpdateStutes',
        ];
    }
    
    /**
     * تحديث الشات
     *
     * @return void
     */
    public function chatReadUpdateStutes($data)
    {
        if ($this->selectedConversation && $data['id'] == $this->selectedConversation->id) {
            foreach ($this->selectedConversation->messages as $message) {
                $this->dispatch('message-updated', $message->id)->to(MessageChat::class);
            }
            $this->dispatch('scroll-chat');
        }
    }

    /**
     * دالة البدا
     *
     * @return void
     */
    public function mount($conversationsUser)
    {
        $this->user = Auth::user();
        $this->conversationsUser = $conversationsUser;
    }
        
    /**
     * دالة البحث عن الاشخاص للمحادثة
     *
     * @return void
     */
    public function updatedSearch()
    {
        $search = $this->search;

        if ($search === '') {
            // إذا كان الحقل فارغًا، أعد تحميل القائمة الأصلية
            $this->getConversationsUser();
        } else {
            $this->conversationsUser = $this->conversationsUser->filter(function ($item) use ($search) {
                return stripos($item->user->name, $search) !== false;
            });
        }
    }
    
    /**
     * اختيار محادثة
     *
     * @param  mixed $id
     * @return void
     */
    public function selectConversation($id)
    {
        $this->messageBody = '';
        $this->reciverId = $id;
        $myId = $this->user->id;

        $conversation = Conversation::where('user_id_1', $id)->where('user_id_2', $myId)->orWhere('user_id_1', $myId)->where('user_id_2', $id)->with('messages')->first();

        if ($conversation) {
            $this->selectedConversation = $conversation;
        } else {
            $conversation = Conversation::create([
                'user_id_1' => min($id, $myId),
                'user_id_2' => max($id, $myId),
                'last_message' => null,
            ]);
            $this->selectedConversation = $conversation;
        }
        
        $conversation->messages()->where('sender_id', $this->reciverId)->whereNull('read_at') ->update([
            'is_read' => true,
            'read_at' => now()
        ]);
        MessageReadedEvent::dispatch($conversation);

        // أطلق حدث لتفعيل التمرير
        $this->dispatch('scroll-chat');
    }

    public function sendMessage()
    {
        if (empty($this->messageBody) && !$this->attachment) return;

        $conversation = Conversation::find($this->selectedConversation->id);
        
        if (!$conversation) return;
        $message = $this->createMessages($conversation);

        SendMessageEvent::dispatch($message);
        $this->selectedConversation->load('messages');
        // أطلق حدث لتفعيل التمرير
        $this->dispatch('scroll-chat');
        // ✅ تفريغ الحقول
        $this->reset(['messageBody', 'attachment']);
    }

    public function createMessages(Conversation $conversation): Message
    {
        $this->validate([
            'messageBody' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $data = [
            'conversation_id' => $conversation->id,
            'sender_id' => $this->user->id,
            'body' => $this->messageBody,
            'is_read' => false,
            'read_at' => null,
        ];

        if ($this->attachment) {
            $path = $this->attachment->store('chat', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $this->attachment->getClientOriginalName();
            $data['file_size'] = $this->attachment->getSize();
            $data['type'] = str_starts_with($this->attachment->getMimeType(), 'image/') ? 'image' : 'file';
        } else {
            $data['type'] = 'text';
        }
            
        return Message::create($data);
    }

    public function newChatMessage($data)
    {
        $con = Conversation::find($data['conversation_id'])->first();
        if ($this->selectedConversation && $data['conversation_id'] == $this->selectedConversation->id) {
            $con->messages()->where('sender_id', $this->reciverId)->whereNull('read_at') ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
            $this->selectedConversation->load('messages');

            MessageReadedEvent::dispatch($con);
            // إرسال حدث لتحديث الكومبوننتات الفرعية
            foreach ($con->messages as $message) {
                $this->dispatch('message-updated', $message->id)->to(MessageChat::class);
            }
            // أطلق حدث لتفعيل التمرير
            $this->dispatch('scroll-chat');
        }else{
            $name = $con->getOtherUser($this->user->id)->name;
            toast()->success('you have new message from ' . $name)->push();
        }
    }

    public function render()
    {
        return view('livewire.chat.chat-interface');
    }
}
