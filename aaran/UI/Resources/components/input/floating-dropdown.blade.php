@props([
    'label' => 'Select Option',
    'id' => 'input_dropdown',
    'options' => [],
    'placeholder' => 'Select...',
])

@php
    $dropdownId = $id . '_dropdown';
@endphp

<div
    x-data="{
        open: false,
        selected: @entangle($attributes->wire('model')),
        selectedLabel: '',
        query: '',
        activeIndex: 0,
        options: {{ json_encode($options) }},
        filtered() {
            if (!this.query) return Object.entries(this.options);
            return Object.entries(this.options).filter(([key, label]) =>
                label.toLowerCase().includes(this.query.toLowerCase())
            );
        },
        init() {
            this.$watch('selected', (value) => {
                if (value && this.options[value]) {
                    this.selectedLabel = this.options[value];
                    this.query = this.options[value];
                } else {
                    this.selectedLabel = '';
                    this.query = '';
                }
            });

            // Set initial value if already selected
            if (this.selected && this.options[this.selected]) {
                this.selectedLabel = this.options[this.selected];
                this.query = this.options[this.selected];
            }
        },
        select(key) {
            this.selected = key;
            this.selectedLabel = this.options[key];
            this.query = this.options[key];
            this.open = false;
        },
        onArrowDown() {
            if (this.activeIndex < this.filtered().length - 1) {
                this.activeIndex++;
            }
        },
        onArrowUp() {
            if (this.activeIndex > 0) {
                this.activeIndex--;
            }
        },
        onEnter() {
            const [key] = this.filtered()[this.activeIndex] || [];
            if (key) this.select(key);
        },
        onBackspace() {
            if (!this.query) {
                this.selected = '';
                this.selectedLabel = '';
                this.open = true;
            }
        },
        onInput() {
            if (this.query === '') {
                this.selectedLabel = '';
            }
            this.open = true;
        }
    }"
    x-init="init"
    @keydown.arrow-down.prevent="onArrowDown"
    @keydown.arrow-up.prevent="onArrowUp"
    @keydown.enter.prevent="onEnter"
    @keydown.escape="open = false"
    @click.away="open = false"
    @keydown.backspace.prevent="onBackspace"
    @input="onInput"
    class="relative w-full"
>
    <!-- Searchable input field -->
    <input
        x-model="query"
        id="{{ $id }}"
        @focus="open = true"
        class="block px-2.5 pb-2.5 pt-3 w-full bg-transparent rounded-lg border-1 appearance-none tracking-wide focus:outline-none peer
           text-gray-900 border-gray-300 focus:ring-cyan-50 focus:border-blue-400"
        type="text"
        :placeholder="selectedLabel ? selectedLabel : '{{ $placeholder }}'"
        autocomplete="off"
    />

    <!-- Floating label -->
    <label for="{{ $id }}"
           class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2
                  peer-focus:text-blue-400 peer-placeholder-shown:scale-100
                  peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2
                  peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-2.5 pointer-events-none">
        {{ $label }}
    </label>

    <!-- Dropdown with keyboard navigation -->
    <ul
        x-show="open && filtered().length"
        x-transition
        class="absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-md max-h-48 overflow-auto"
    >
        <template x-for="([key, label], index) in filtered()" :key="key">
            <li
                @click="select(key)"
                :class="{
                    'bg-blue-100': index === activeIndex,
                    'bg-white': index !== activeIndex
                }"
                class="flex items-center justify-between px-4 py-2 hover:bg-blue-100 cursor-pointer"
                @mouseenter="activeIndex = index"
            >
                <span x-text="label"></span>
                <template x-if="selected === key">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                </template>
            </li>
        </template>
    </ul>
</div>
