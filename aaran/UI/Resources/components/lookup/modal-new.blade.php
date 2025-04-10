@props(['id', 'height', 'maxWidth' ])

@php
    $id = $id ?? md5($attributes->wire('model'));

    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '4xl' => 'sm:max-w-4xl',
        '6xl' => 'sm:max-w-6xl',
    ][$maxWidth ?? '4xl'];
@endphp

<div x-show="showCreateModal"
     @click.away="showCreateModal = false"
     x-cloak
     x-on:close.stop="show = false"
     x-on:keydown.escape.window="showCreateModal = false"
     x-trap.inert.noscroll="showCreateModal"
     class="absolute z-20">

    <div class="relative" role="dialog">

        <div class="fixed inset-0 bg-gray-800/75"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div
                class="flex min-h-full justify-center items-center">
                <div
                    class="relative sm:w-full {{ $maxWidth }} sm:mx-auto"
                    >
                    <div class="bg-white rounded-t-lg px-4 pt-5 pb-2">
                        {{$slot}}
                    </div>
                    <div class="bg-gray-100  rounded-b-lg px-4 py-3 flex gap-3 justify-end">

                        <x-Ui::button.back-x @click="showCreateModal = false"/>

                        <x-Ui::button.save-x wire:click.prevent="save"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
