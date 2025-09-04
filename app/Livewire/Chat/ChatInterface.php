<?php

namespace App\Livewire\Chat;

use App\Events\SendMessageEvent;
use App\Models\Message;
use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatInterface extends Component
{
    public $user;
    public $conversationsUser, $selectedConversation, $search = '';
    public $messageBody, $attachment, $reciverId;

    public function getListeners()
    {
        return [
            "echo-private:chat." . Auth::id() . ",SendMessageEvent" => 'newChatMessage'
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->getConversationsUser();
    }
    
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

    private function getConversationsUser()
    {
        if ($this->user->role == 'guardian') {
            $this->conversationsUser = $this->user->guardian->teachers()->with('user')->get();
        }elseif($this->user->role == 'teacher'){
            $this->conversationsUser = $this->user->teacher->guardians()->with('user')->get();
        }
    }

    public function selectConversation($id)
    {
        $this->fill(['messageBody' => '']);
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
    }

    public function sendMessage()
    {
        if (empty($this->messageBody) && !$this->attachment) return;

        $conversation = Conversation::find($this->selectedConversation->id);
        if (!$conversation) return;

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

        $message = Message::create($data);
        broadcast(new SendMessageEvent($message));
        $this->selectedConversation->load('messages');
        // ✅ تفريغ الحقول
        $this->reset(['messageBody', 'attachment']);
    }

    public function newChatMessage($data)
    {
        if ($this->selectedConversation && $data['conversation_id'] == $this->selectedConversation->id) {
            $this->selectedConversation->load('messages');
        }
    }

    public function render()
    {
        return view('livewire.chat.chat-interface');
    }
}
