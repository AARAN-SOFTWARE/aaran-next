@props([
    'id',
    'maxWidth' => '2xl',
    'attributes'=>null
])

<div>
    <div x-data="{ showEditModal: @entangle('showEditModal')}">
        <div
            x-show="showEditModal"
            @click.away="showEditModal = false"
            x-cloak
            x-on:close.stop="showEditModal = false"
            x-on:keydown.escape.window="showEditModal = false"
            x-trap.inert.noscroll="showEditModal"
            class="absolute z-20">

            <div class="relative" role="dialog">

                <div class="fixed inset-0 bg-gray-800/75"></div>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div
                        class="flex min-h-full justify-center items-center">
                        <div class="relative sm:w-full sm:max-w-4xl sm:mx-auto">

                            <div class="bg-white rounded-t-lg px-2 pb-2">

                                <div class="text-lg text-neutral-400 pt-2 px-2">
                                    {{$id === null ? 'New Entry' : 'Edit Entry'}}
                                </div>

                                <div class="mt-2">
                                    {{$slot}}
                                </div>
                            </div>

                            <div class="bg-gray-100  rounded-b-lg px-4 py-3 flex gap-3 justify-end">

                                <div class="w-full flex justify-between gap-3">
                                    <div class="py-2">
                                        <label for="active_id"
                                               class="inline-flex relative items-center cursor-pointer">
                                            <input type="checkbox" id="active_id" class="sr-only peer"
                                                   wire:model="active_id">
                                            <div
                                                class="w-10 h-5 bg-gray-200 rounded-full peer peer-focus:ring-2
                                        peer-focus:ring-blue-300
                                         peer-checked:after:translate-x-full peer-checked:after:border-white
                                         after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300
                                         after:border after:rounded-full after:h-4 after:w-4 after:transition-all
                                         peer-checked:bg-blue-600"></div>
                                            <span
                                                class="ml-3 sm:text-sm text-xs font-medium text-gray-900">Active</span>
                                        </label>
                                    </div>

                                    <div class="flex gap-3">

                                        <x-Ui::button.cancel-x
                                            wire:click.prevent="$set('showEditModal', false)" {{$attributes}} />

                                        <x-Ui::button.save-x wire:click.prevent="save"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
