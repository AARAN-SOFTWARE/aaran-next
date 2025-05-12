@props([
    'buttonLabel' => 'Back', // Default is Back
    'class' => ''
])
@php
    // color and icon
    $buttonStyles = [
        'Back' => [
            'bg' => 'bg-blue-600 hover:bg-blue-700',
            'hover' => 'bg-blue-500',
            'icon' => "M9.195 18.44c1.25.714 2.805-.189 2.805-1.629v-2.34l6.945 3.968c1.25.715 2.805-.188 2.805-1.628V8.69c0-1.44-1.555-2.343-2.805-1.628L12 11.029v-2.34c0-1.44-1.555-2.343-2.805-1.628l-7.108 4.061c-1.26.72-1.26 2.536 0 3.256l7.108 4.061Z"
        ],
        'New' => [
            'bg' => 'bg-green-600 hover:bg-green-700',
            'hover' => 'bg-green-500',
            'icon' => 'M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z'
        ],
        'Cancel' => [
            'bg' => 'bg-gray-600 hover:bg-gray-700',
            'hover' => 'bg-gray-500',
            'icon' => 'M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z'
        ],
        'Save' => [
            'bg' => 'bg-green-600 hover:bg-green-700',
            'hover' => 'bg-green-500',
            'icon' => 'M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM16.28 9.28a.75.75 0 0 0-1.06-1.06L11 12.44l-2.22-2.22a.75.75 0 0 0-1.06 1.06l2.75 2.75a.75.75 0 0 0 1.06 0l4.75-4.75Z'
       ],
        'Delete' => [
            'bg' => 'bg-red-600 hover:bg-red-700',
            'hover' => 'bg-red-500',
            'icon' => 'M9 3a1 1 0 0 0-1 1v1H5.5a.5.5 0 0 0 0 1h.653l.88 13.112A2 2 0 0 0 9.028 21h5.944a2 2 0 0 0 1.995-1.888L17.847 6H18.5a.5.5 0 0 0 0-1H16V4a1 1 0 0 0-1-1H9Zm1 6.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7Zm4 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7Z'
        ],
       'Print' => [
            'bg' => 'bg-violet-600 hover:bg-violet-700',
            'hover' => 'bg-violet-500',
            'icon' => 'M3 6a3 3 0 0 1 3-3h10.586a1 1 0 0 1 .707.293l3.414 3.414a1 1 0 0 1 .293.707V21a1 1 0 0 1-1 1H5a2 2 0 0 1-2-2V6Zm12 13a1 1 0 1 0 0-2H9a1 1 0 0 0 0 2h6Zm-6-8a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1H9Zm0-2h6V5H9v4Z'
        ]
    ];

    $style = $buttonStyles[$buttonLabel] ?? $buttonStyles['Back'];
@endphp

<button
    class="overflow-hidden relative w-25 h-11 text-white font-medium border-none rounded-md tracking-widest cursor-pointer z-10 self-center group {{ $style['bg'] }}"
    {{$attributes}}>
    <span
        class="absolute top-0 left-0 flex h-full w-0 transition-all duration-500 ease-out transform group-hover:w-full opacity-90 {{ $style['hover'] }}">
    </span>

    <span class="relative sm:text-lg text-sm flex items-center justify-center h-full">

        <span class="transition-opacity duration-200 group-hover:opacity-0">
            {{ $buttonLabel }}
        </span>

        <!-- Icon -->
        <span class="absolute transition-opacity duration-200 opacity-0 group-hover:opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="size-6">
                <path fill-rule="evenodd" clip-rule="evenodd" d="{{ $style['icon'] }}" />
            </svg>
        </span>
    </span>
</button>
