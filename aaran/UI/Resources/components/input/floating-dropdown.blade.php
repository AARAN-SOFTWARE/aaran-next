@props([
    'label' => 'Select Option',
    'id' => 'input_dropdown',
    'options' => [],
])

@php
    $dropdownId = $id . '_dropdown';
@endphp

<div
    x-data="{
        open: false,
        selected: @entangle($attributes->wire('model')),
        select(option) {
            this.selected = option;
            this.open = false;
        }
    }"
    @click.away="open = false"
    class="relative w-full"
>
    <!-- Visible input (readonly, controlled by Alpine) -->
    <input
        x-model="selected"
        readonly
        id="{{ $id }}"
        @focus="open = true"
        class="block px-2.5 pb-2.5 pt-3 w-full bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 peer"
        type="text"
        placeholder=" "
    />

    <!-- Floating label -->
    <label for="{{ $id }}"
           class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2
                  peer-focus:text-blue-400 peer-placeholder-shown:scale-100
                  peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2
                  peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-2.5 pointer-events-none">
        {{ $label }}
    </label>

    <!-- Dropdown list -->
    <ul
        x-show="open"
        x-transition
        class="absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-md max-h-48 overflow-auto"
    >
        @foreach ($options as $value => $display)
            <li
                @click="select('{{ $value }}')"
                class="px-4 py-2 hover:bg-blue-100 cursor-pointer"
            >
                {{ $display }}
            </li>
        @endforeach
    </ul>
</div>
