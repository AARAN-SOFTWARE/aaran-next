<div x-data="{ showDropdown: @entangle('showDropdown'), showCreateModal: @entangle('showCreateModal') }"
     x-on:keydown.arrow-down.prevent="$wire.incrementHighlight()"
     x-on:keydown.arrow-up.prevent="$wire.decrementHighlight()"
     x-on:keydown.enter.prevent="$wire.selectHighlighted()"
     x-on:keydown.escape.prevent="$wire.hideDropdown()"
     class="relative w-full">

    <input
        type="text"
        wire:model.live.debounce="search"
        wire:input="searchBy"
        wire:focus="searchBy"
        wire:blur="hideDropdown"

        class="block px-2.5 pb-2.5 pt-4 w-full text-xs text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none
                                      focus:outline-none focus:ring-2 focus:ring-cyan-50 focus:border-blue-600 peer"
        placeholder=" "/>
    <label for="floating_outlined"
           class="absolute text-xs text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white
                               px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                               peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4
                               rtl:peer-focus:left-auto start-1 pointer-events-none">
        City Name
    </label>

    @if($showDropdown)
        <div x-show="showDropdown" x-cloak x-transition>
            <div class="absolute z-20 w-full my-2">
                <li class="block py-2 shadow-md w-full
                        rounded-lg border-transparent flex-1 appearance-none border
                        bg-white text-gray-800 ring-1 ring-blue-600">
                    <ul class="overflow-y-scroll h-44 text-xs">
                        @forelse ($results as $index => $row)
                            <li wire:click="selectCity(@js($row))"
                                class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-zinc-100 text-blue-900 h-fit ml-2 mr-2 rounded-md
                                {{ $highlightIndex === $index ? 'bg-blue-100 ' : '' }}">
                                {{ $row->vname }}
                            </li>
                        @empty
                            <li class="px-4 py-2 text-gray-500 text-sm tracking-wider">No Results ...</li>
                            <button @click="showCreateModal = true;" wire:click="createNew"
                                    class="w-full inline-flex items-center gap-x-3 px-4 py-2  text-blue-600 border-t border-b border-gray-300px-2 hover:bg-blue-100 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="size-6">
                                    <path fill-rule="evenodd"
                                          d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <span>New City</span>
                            </button>

                        @endforelse
                    </ul>
                </li>
            </div>
        </div>
    @endif
</div>
