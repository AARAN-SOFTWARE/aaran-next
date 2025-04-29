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
        selectedLabel: '',
        options: {{ json_encode($options) }},
        init() {
            if (this.selected && this.options[this.selected]) {
                this.selectedLabel = this.options[this.selected];
            }
        },
        select(option) {
            this.selected = option;
            this.selectedLabel = this.options[option];
            this.open = false;
        }
    }"
    x-init="init"
    @click.away="open = false"
    class="relative w-full"
>
    <!-- Input showing selected label, not the key -->
    <input
        x-model="selectedLabel"
        readonly
        id="{{ $id }}"
        @focus="open = true"
        class="block px-2.5 pb-2.5 pt-3 w-full bg-white border border-gray-300 rounded-lg focus:outline-none  focus:ring-cyan-50 focus:border-blue-400 peer"
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

    <!-- Dropdown with tick -->
    <ul
        x-show="open"
        x-transition
        class="absolute z-50 mt-1.5 w-full bg-white border border-gray-300 rounded-md shadow-md max-h-48 overflow-auto"
    >
        <template x-for="(label, key) in options" :key="key">
            <li
                @click="select(key)"
                class="flex items-center justify-between px-4 py-2 hover:bg-blue-100 cursor-pointer"
            >
                <span x-text="label"></span>
                <template x-if="selected === key">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 13l4 4L19 7" />
                    </svg>
                </template>
            </li>
        </template>
    </ul>
</div>
