@props([
    'placeholder' => '',
    'class'=>'',
    'label'=>''
])
<div x-data="{isTyped: false}" @click.away="isTyped = false">
    <div class="relative">
        <label for="{{$label}}" class="">{{$label}}</label>
            <input
                id="{{$label}}"
                type="search"
                wire:model.live="searches"
                autocomplete="off"
                placeholder="{{$placeholder}}.."
                @focus="isTyped = true"
                @keydown.escape.window="isTyped = false"
                @keydown.tab.window="isTyped = false"
                @keydown.enter.prevent="isTyped = false"
                wire:keydown.arrow-up="decrementHighlight"
                wire:keydown.arrow-down="incrementHighlight"
                wire:keydown.enter="selectHighlight"
                class="block w-full {{$class}}"
            />

        <div x-show="isTyped"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-cloak
        >
            <div class="absolute z-20 w-full mt-2">
                <div class="block py-1 shadow-md w-full
                rounded-lg border-transparent flex-1 appearance-none border
                                 bg-white text-gray-800 ring-1 ring-purple-600">
                    <ul class="overflow-y-scroll h-96">
                        {{$slot}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
