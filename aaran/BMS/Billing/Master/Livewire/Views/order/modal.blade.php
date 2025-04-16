<div x-data="{ showCreateModal: @entangle('showCreateModal')}">
    <div
        x-show="showCreateModal"
        @click.away="showCreateModal = false"
        x-cloak
        x-on:close.stop="showCreateModal = false"
        x-on:keydown.escape.window="showCreateModal = false"
        x-trap.inert.noscroll="showCreateModal"
        class="absolute z-20">

        <div class="relative" role="dialog">

            <div class="fixed inset-0 bg-gray-800/75"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div
                    class="flex min-h-full justify-center items-center">
                    <div class="relative sm:w-full sm:max-w-4xl sm:mx-auto">

                        <div class="bg-white rounded-t-lg px-4 pb-4">

                            <div class="text-lg text-neutral-300 py-3 left-2">Create New</div>

                            <div class="flex flex-col gap-3">
                                <div>
                                    <x-Ui::input.floating wire:model="vname" label="Order No"/>
                                    <x-Ui::input.error-text wire:model="vname"/>
                                </div>

                                <x-Ui::input.floating wire:model="order_name" label="Order Name"/>
                            </div>

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
</div>

