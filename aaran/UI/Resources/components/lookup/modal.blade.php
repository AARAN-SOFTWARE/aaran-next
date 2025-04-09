@props([
    'showModal' =>false,
    'width' => 'w-1/3',
    'height'=> 'h-80',
    'label'=> null
])
<div>
    <li class="px-4 py-2 text-gray-500 text-sm tracking-wider">No Results Found ...</li>
    <button wire:click="$set('showModal',true); "
       class="w-full inline-flex items-center gap-x-3 px-4 py-2  text-blue-600 border-t border-b border-gray-300px-2 hover:bg-blue-100 cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
        </svg>
        <span>New {{$label}}</span>
    </button>

    @if($showModal)
        <div
            x-data
            x-init="$refs.vname.focus()"
            x-init="document.body.classList.add('overflow-hidden')"
            x-on:keydown.window.escape="$wire.set('showModal', false)"
            @click.self="$wire.set('showModal', false)"
            x-on:destroy="document.body.classList.remove('overflow-hidden')"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
        >

            <div
                    class=" bg-white shadow-md m-auto rounded-md fixed inset-0 inline-block overflow-y-auto {{$width}} {{$height}}" @click.stop>

                <div class="flex flex-col h-full justify-between">

                    <header class="p-2">
                        <h3 class="font-bold text-lg border-b border-gray-400 text-gray-500 py-2">&nbsp;&nbsp;&nbsp;&nbsp;Create&nbsp;new</h3>
                    </header>

                    <main class="px-5 m-3 space-y-4">
                        {{$slot}}
                    </main>

                    <footer class="flex justify-end px-2 py-4 mt-3 bg-gray-200 rounded-b-md gap-3">

                        <x-Ui::button.back-x wire:click.prevent="$set('showModal', false)" />

                        <x-Ui::button.save-x wire:click.prevent="save" />
                    </footer>
                </div>
            </div>
        </div>
    @endif
</div>
