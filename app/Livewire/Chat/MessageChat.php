<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MessageChat extends Component
{
    public $message, $user;
    protected $listeners = ['message-updated' => 'refreshMessage'];

    public function refreshMessage($messageId)
    {
        if ($messageId == $this->message->id) {
            $this->message = Message::find($messageId);
        }
    }
    public function mount($message)
    {
        $this->message = $message;
        $this->user = Auth::user();
    }
    public function render()
    {
        return view('livewire.chat.message-chat');
    }
}
