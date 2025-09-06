<div class="flex {{ $message->sender_id == $user->id ? 'justify-end' : 'justify-start' }}">
    <div
        class="max-w-xs px-4 py-2 rounded-lg {{ $message->sender_id == $user->id ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-bl-none shadow' }}">
        <p class="text-sm wrap-break-word">{{ $message->body }}</p>
        <span class="text-xs opacity-70 mt-1 block">
            {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}
            @if ($message->sender_id == $user->id)
                @if ($message->read_at)
                    <span class="text-green-300">✓✓</span>
                @else
                    <span class="text-white">✓</span>
                @endif
            @endif
        </span>
    </div>
</div>
