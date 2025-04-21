<div>
    <button type="button" wire:click.prevent="showSwitchModal"
            class="text-gray-600 bg-white focus:outline-none hover:bg-gray-100 font-semibold sm:px-2 px-0.5 sm:py-2 py-1 rounded-lg text-xs cursor-pointer">
        {{$defaultCompany->vname ?:'Select Company' }}
        &nbsp;-&nbsp;{{ \Aaran\Assets\Enums\Acyear::tryFrom($defaultCompany->acyear_id)->getName()}}
    </button>

    <div
        x-data="{ showModal: @entangle('showModal')}"
        x-show="showModal"
        x-on:close.stop="showModal = false"
        x-on:keydown.escape.window="showModal = false"
        x-trap.inert.noscroll="showModal"
        class="relative z-10"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/65 transition-opacity" aria-hidden="true"></div>

        <!-- Modal container -->
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!-- Modal panel -->
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div
                            class=" flex flex-row justify-between px-6 pt-4 text-xl font-semibold text-blue-600/100 dark:text-blue-500/100 ">
                            <div class="text-xl ">Choose Company</div>
                            <div>
                                <div>
                                    <x-Ui::input.model-select wire:model="defaultCompany.acyear_id" wire:change="changeAcyear" :label="'AcYear'">
                                        <option class="text-gray-400"> choose ..</option>
                                        @foreach(\Aaran\Assets\Enums\Acyear::cases() as $year)
                                            <option value="{{$year->value}}">{{$year->getName()}}</option>
                                        @endforeach
                                    </x-Ui::input.model-select>
                                </div>

                            </div>
                        </div>

                        <x-Ui::forms.section-border class="py-2"/>

                        <div class=" mt-4 mb-5 px-6  pt-4">
                            <table class="w-full border overscroll-x-scroll">
                                @forelse ($companies as $index =>  $row)
                                    <x-Ui::table.row class="border rounded-md">
                                        <x-Ui::table.cell-text>
                                            <button wire:click.prevent="switchCompany({{$row->id}})"
                                                    class="flex px-3 text-gray-600 truncate sm:text-xl text-sm font-semibold text-left w-full cursor-pointer">
                                                {{ $row->vname}}
                                            </button>
                                        </x-Ui::table.cell-text>

                                        <x-Ui::table.cell-text>
                                            <button wire:click.prevent="switchCompany({{$row->id}})"
                                                    class="flex px-2 text-gray-600 sm:text-xl text-sm font-semibold justify-end w-full cursor-pointer">
                                                {{  $row->vname === $defaultCompany->vname ?'Default': '-'  }}

                                            </button>
                                        </x-Ui::table.cell-text>

                                    </x-Ui::table.row>
                                @empty
                                    {{--                                    <x-table.empty/>--}}
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
