@props([
    'label' => '',
    'autofocus' => false,
    'theme' => 'default',
    'id' => 'floating_select'
])

@php
    $themes = [
        'default' => 'text-gray-900 border-gray-300 focus:ring-cyan-50 focus:border-blue-400',
        'primary' => 'text-blue-800 border-blue-300 focus:ring-blue-100 focus:border-blue-500',
        'danger' => 'text-red-800 border-red-300 focus:ring-red-100 focus:border-red-500',
    ];

    $baseClasses = 'block px-2.5 pb-2.5 pt-3 w-full bg-transparent rounded-lg border-1 appearance-none tracking-wide focus:outline-none peer';
    $selectClass = $baseClasses . ' ' . ($themes[$theme] ?? $themes['default']);
@endphp

<div class="relative w-full">
    <select
        {{ $attributes->merge([
            'class' => $selectClass,
            'id' => $id,
            'autofocus' => $autofocus,
        ]) }}
    >
        <option class="bg-white py-2" disabled selected hidden value="">Select...</option>
        {{ $slot }}
    </select>

    <label for="{{ $id }}"
           class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300
           transform scale-75 top-2 z-10 origin-[0]
           bg-white px-2 peer-focus:px-2 peer-focus:text-blue-400
           peer-focus:dark:text-blue-300
           peer-[value='']:scale-100 peer-[value='']:-translate-y-1/2 peer-[value='']:top-1/2
           peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4
           rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1 pointer-events-none">
        {{ $label }}
    </label>
</div>
