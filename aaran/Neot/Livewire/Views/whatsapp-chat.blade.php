<div class="flex flex-col h-screen bg-gray-100">
    <div class="flex-1 overflow-y-auto p-4">
        @foreach ($messages as $msg)
            <div class="{{ $msg->direction === 'outbound' ? 'text-right' : 'text-left' }}">
                <div class="inline-block bg-{{ $msg->direction === 'outbound' ? 'blue' : 'gray' }}-200 p-3 rounded mb-2">
                    {{ $msg->message }}
                </div>
            </div>
        @endforeach
    </div>

    <div class="p-4 bg-white flex items-center gap-2">
        <input wire:model="text" wire:keydown.enter="send" type="text"
               class="flex-1 border rounded-full px-4 py-2 focus:outline-none focus:ring"
               placeholder="Type your message...">
        <button wire:click="send"
                class="px-4 py-2 bg-blue-500 text-white rounded-full">
            Send
        </button>
    </div>
</div>
