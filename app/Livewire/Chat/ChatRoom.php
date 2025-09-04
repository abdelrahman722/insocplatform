<?php

namespace App\Livewire\Chat;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use App\Models\Conversation;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ChatRoom extends Component
{

    use WithFileUploads;

    public $conversations, $selectedConversation, $search = '';
    public string $messagebody;
    public $attachment;
    
    public function mount()
    {
        $this->messagebody = '';
        $this->attachment = null;
        $this->selectedConversation = null;
        $this->loadConversations();
    }

    public function updatingSearch()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $user = Auth::user();
        $schoolId = $user->school_id;

        // 1. المحادثات الحالية (نفس المدرسة فقط)
        $existingConversations = Conversation::where('school_id', $schoolId)
            ->where(function ($query) use ($user) {
                $query->where('user_id_1', $user->id)
                    ->orWhere('user_id_2', $user->id);
            })
            ->with(['user_1', 'user_2', 'lastMessage'])
            ->get();

        $existing = $existingConversations->map(function ($conv) use ($user) {
            $other = $conv->user_1->id === $user->id ? $conv->user_2 : $conv->user_1;
            return [
                'type' => 'existing',
                'id' => $conv->id,
                'name' => $other->name,
                'avatar' => $other->initials(),
                'last_message' => $conv->lastMessage?->body ?? 'محادثة نشطة',
                'is_read' => $conv->lastMessage?->is_read ?? true,
                'created_at' => $conv->lastMessage?->created_at ?? $conv->created_at,
            ];
        });

        // 2. المحادثات المحتملة (أولياء أمور طلاب المُدرِّس فقط)
        $possibleUsers = collect();

        if ($user->role === 'guardian') {
            // ولي الأمر يمكنه الدردشة مع جميع المدرسين في مدرسته
            $possibleUsers = User::where('role', 'teacher')
                ->where('school_id', $schoolId);
        } 
        elseif ($user->role === 'teacher') 
        {
            // المدرس يمكنه الدردشة فقط مع أولياء أمور طلابه
            $possibleUsers = User::where('role', 'guardian')
                ->where('school_id', $schoolId)
                ->whereIn('id', function ($query) use ($user) {
                    $query->select('guardians.id')
                        ->from('users as guardians')
                        ->join('guardian_student', 'guardian_student.guardian_id', '=', 'guardians.id')
                        ->join('students', 'students.id', '=', 'guardian_student.student_id')
                        ->join('semesters', 'students.semester_id', '=', 'semesters.id')
                        ->join('sections', 'semesters.id', '=', 'sections.semester_id')
                        ->where('sections.teacher_id', $user->id)
                        ->where('students.school_id', $user->school_id)
                        ->distinct();
                });
        }

        // تطبيق الفلترة حسب البحث
        if ($this->search) {
            $possibleUsers = $possibleUsers->where('name', 'like', '%' . $this->search . '%');
        }

        $possibleUsers = $possibleUsers->get();

        $possible = $possibleUsers->map(function ($person) {
            return [
                'type' => 'new',
                'id' => null,
                'name' => $person->name,
                'avatar' => $person->initials(),
                'last_message' => 'محادثة جديدة',
                'is_read' => true,
                'created_at' => now(),
                'other_id' => $person->id,
            ];
        });

        // دمج النتائج
        $this->conversations = collect($existing->toArray())
            ->concat($possible->toArray())
            ->sortByDesc('created_at')
            ->values();
    }

    public function selectConversation($conversationId = null, $otherId = null)
    {
        $user = Auth::user();
        if ($conversationId) {
            $conversation = Conversation::find($conversationId);
        } else {
            $conversation = Conversation::firstOrCreate(
                ['user_id_1' => min($user->id, $otherId), 'user_id_2' => max($user->id, $otherId)],
            );
        }

        if (!$conversation || !$conversation->involvesUser($user->id)) {
            $this->dispatch('error', 'غير مصرح لك بالوصول إلى هذه المحادثة.');
            return;
        }

        $this->selectedConversation = $conversation->load(['messages.sender'])->toArray();
        $this->messagebody = '';
        $this->attachment = null;
        // تعيين الرسائل كمقروءة
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $this->loadConversations(); // تحديث القائمة
    }

   public function sendMessage()
    {
        $this->validate([
            'messagebody' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|max:10240',
        ]);

        if (empty($this->messagebody) && !$this->attachment) {
            return;
        }

        $conversation = Conversation::find($this->selectedConversation['id']);
        if (!$conversation) return;

        $data = [
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'body' => $this->messagebody,
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

        // ✅ استخدم unshift لوضع الرسالة في بداية المصفوفة
        $this->selectedConversation['messages'] = collect($this->selectedConversation['messages'])
            ->prepend(array_merge($message->toArray(), ['read_at' => $message->read_at]))
            ->toArray();

        // ✅ تفريغ الحقول
        $this->reset(['messagebody', 'attachment']);
    }

    public function render()
    {
        return view('livewire.chat.chat-room');
    }
}
