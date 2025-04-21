<div>
    <button type="button" wire:click="create"
            class="text-gray-600 bg-white focus:outline-none hover:bg-gray-100 font-semibold sm:px-2 px-0.5 sm:py-2 py-1 rounded-lg text-xs">
{{--        {{$defaultCompany->company->vname ?:'Select Company' }}--}}
{{--        &nbsp;-&nbsp;{{\Aaran\Common\Models\Common::name($defaultCompany->acyear)}}--}}
    </button>

    <x-Ui::jet.modal wire:model.defer="showEditModal">

        <div
            class=" flex flex-row justify-between px-6 pt-4 text-xl font-semibold text-blue-600/100 dark:text-blue-500/100 ">
            <div class="text-xl ">Choose Company</div>
            <div>
                <livewire:controls.select.acyear-select/>
            </div>
        </div>

        <x-Ui::forms.section-border class="py-2"/>

        <div class=" mt-4 mb-5 px-6  pt-4">
            <table class="w-full border overscroll-x-scroll">
                @forelse ($companies as $index =>  $row)
                    <x-Ui::table.row class="border rounded-md">
                        <x-Ui::table.cell-text>
                            <button wire:click.prevent="switchCompany({{$row->id}})"
                                    class="flex px-3 text-gray-600 truncate sm:text-xl text-sm font-semibold text-left w-full">
                                {{ $row->vname}}
                            </button>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text>
                            <button wire:click.prevent="switchCompany({{$row->id}})"
                                    class="flex px-2 text-gray-600 sm:text-xl text-sm font-semibold justify-end w-full">
                                {{  $row->vname === $defaultCompany->company->vname ?'Default': '-'  }}

                            </button>
                        </x-Ui::table.cell-text>

                    </x-Ui::table.row>
                @empty
                    {{--                    <x-table.empty/>--}}
                @endforelse
            </table>
        </div>
    </x-Ui::jet.modal>
</div>
