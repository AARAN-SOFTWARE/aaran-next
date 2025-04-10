<div>
    <div class="xl:flex-col w-full gap-2 font-lex text-xs">

        <div x-data="{isTyped: @entangle('contactTyped')}" @click.away="isTyped = false" class="w-full">

            <div class="relative ">
                <div class="relative font-lex">
                    <input
                        id="contact_name"
                        wire:model.live.debounce="contact_name"
                        wire:keydown.arrow-up="decrementContact"
                        wire:keydown.arrow-down="incrementContact"
                        wire:keydown.enter="enterContact"
                        type="search"
                        autocomplete="off"
                        @focus="isTyped = true"
                        @keydown.escape.window="isTyped = false"
                        @keydown.tab.window="isTyped = false"
                        @keydown.enter.prevent="isTyped = false"

                        class="block px-2.5 pb-2.5 pt-4 w-full text-xs text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none
                                  focus:outline-none focus:ring-2 focus:ring-cyan-50 focus:border-blue-600 peer"
                        placeholder=" "/>
                    <label for="floating_outlined"
                           class="absolute text-xs text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white
                           px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                           peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4
                           rtl:peer-focus:left-auto start-1 pointer-events-none">
                        Party Name
                    </label>
                </div>


                @error('contact_name')
                <span
                    class="text-red-500">{{'The Party Name is Required.'}}</span>
                @enderror


                <div x-show="isTyped"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     x-cloak
                     class="">
                    <div class="absolute z-20 w-full my-2">
                        <div class="block py-2 shadow-md w-full
                                rounded-lg border-transparent flex-1 appearance-none border
                                 bg-white text-gray-800 ring-1 ring-blue-600">
                            <ul class="overflow-y-scroll h-44 text-xs">

                                @if($contactCollection)
                                    @forelse ($contactCollection as $index => $contact)

                                        <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-zinc-100 text-blue-900 h-fit ml-2 mr-2 rounded-md
                                                    text-xs my-1 {{$highlightContact === $index ? 'bg-blue-100' : ''}} "

                                            wire:click.prevent="setContact('{{$contact->vname}}','{{$contact->id}}')"
                                            x-on:click="isTyped = false">

                                            {{ $contact->vname }}

                                        </li>
                                    @empty
                                        @livewire('master::contact.modal',[$contact_name])
                                    @endforelse
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
