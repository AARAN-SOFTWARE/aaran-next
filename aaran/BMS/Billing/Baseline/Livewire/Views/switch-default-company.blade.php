<div>
    <x-slot name="header">Switch Company</x-slot>

    <x-Ui::forms.m-panel>

        <x-Ui::alerts.notification/>


        <div class="flex flex-col sm:flex-row gap-4 mb-4 justify-end-safe px-20 w-full items-center">

            <div>Accounting Year</div>
            <x-Ui::input.model-select wire:model="defaultCompany.acyear_id" wire:change="changeAcyear"
                                      class="w-32 text-xl">
                <option class="text-gray-400"> choose ..</option>
                @foreach(\Aaran\Assets\Enums\Acyear::cases() as $year)
                    <option class="text-xl" value="{{$year->value}}">{{$year->getName()}}</option>
                @endforeach
            </x-Ui::input.model-select>
        </div>


        <!-- Table Data ----------------------------------------------------------------------------------------------->

        <x-Ui::table.form>
            <x-slot:table_header>
                <x-Ui::table.header-serial/>
                <x-Ui::table.header-text sortIcon="none" :left="true">
                    Name
                </x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none" center> Ac Year</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none" center> Default</x-Ui::table.header-text>

                <x-Ui::table.header-action/>
            </x-slot:table_header>

            <x-slot:table_body>
                @foreach($list as $index=>$row)
                    <x-Ui::table.row>
                        <x-Ui::table.cell-text>
                            <button wire:click.prevent="switchCompany({{$row->id}})"
                                    class="flex px-3 text-gray-600 truncate sm:text-xl text-sm font-semibold w-full cursor-pointer">
                                {{$index+1}}
                            </button>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text left>
                            <button wire:click.prevent="switchCompany({{$row->id}})"
                                    class="flex px-3 text-gray-600 truncate sm:text-xl text-sm font-semibold w-full cursor-pointer">
                                {{$row->vname}}
                            </button>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text left>
                            <button wire:click.prevent="switchCompany({{$row->id}})"
                                    class="flex px-3 text-gray-600 truncate sm:text-xl text-sm font-semibold w-full cursor-pointer">
                                {{  $row->vname === $defaultCompany->vname ? \Aaran\Assets\Enums\Acyear::tryFrom(session('acyear_id'))->getName(): '-'  }}
                            </button>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text center>
                            <button wire:click.prevent="switchCompany({{$row->id}})"
                                    class="flex px-3 text-gray-600 truncate sm:text-xl text-sm font-semibold w-full justify-center cursor-pointer">
                                {{  $row->vname === $defaultCompany->vname ?'Default': '-'  }}
                            </button>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text center>
                            <button wire:click.prevent="switchCompany({{$row->id}})"
                                    class="flex px-3 text-gray-600 truncate sm:text-xl text-sm font-semibold justify-center w-full cursor-pointer">

                                @if($row->vname === $defaultCompany->vname)
                                    <x-Ui::icons.icon :icon="'check-circle'" class="w-10 h-auto block text-green-500"/>
                                @else
                                    <x-Ui::icons.icon :icon="'x-circle'" class="w-10 h-auto block text-red-500"/>
                                @endif

                            </button>
                        </x-Ui::table.cell-text>

                    </x-Ui::table.row>
                @endforeach
            </x-slot:table_body>

        </x-Ui::table.form>

    </x-Ui::forms.m-panel>
</div>
