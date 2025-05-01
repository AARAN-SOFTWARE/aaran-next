<div>
    <x-slot name="header">Tally Handshake</x-slot>

    @if ($response['status'] === 'error')
        <p class="text-red-500">Error: {{ $response['message'] }}</p>
    @else
        <pre class="bg-gray-100 p-2 rounded text-sm">{{ $response['body'] }}</pre>
    @endif
</div>
