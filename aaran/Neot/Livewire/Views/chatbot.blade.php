<div>
    <x-slot name="header">Neot -Chat Bot</x-slot>

    @foreach ($chatHistory as $chat)
        @if ($chat['sender'] === 'user')
            <div class="user-message">{{ $chat['message'] }}</div>
        @else
            <div class="bot-message">{!! $chat['message'] !!}</div>
        @endif
    @endforeach

    <input wire:model="message" wire:keydown.enter="sendMessage" placeholder="Type your message..." />
</div>
