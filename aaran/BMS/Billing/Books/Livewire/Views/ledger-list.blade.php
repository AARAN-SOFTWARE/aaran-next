<div>
    <x-slot name="header">Ledger </x-slot>

    <!-- Top Controls ------------------------------------------------------------------------------------------------->

    <x-aaran-ui::forms.m-panel>
        <x-aaran-ui::alerts.notification />

        <x-aaran-ui::forms.top-controls :show-filters="$showFilters"/>

        <x-aaran-ui::table.caption :caption="'Ledger'">
            {{$list->count()}}
        </x-aaran-ui::caption>

         <x-aaran-ui::table.form>

            <!-- Table Header ----------------------------------------------------------------------------------------->

            <x-slot:table_header name="table_header" class="bg-green-600">
                <x-aaran-ui::table.header-serial width="20%"/>

                <x-aaran-ui::table.header-text sortIcon="none">Ledger</x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text wire:click.prevent="sortBy('vname')" sortIcon="{{$getListForm->sortAsc}}">
                    Name
                </x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text sortIcon="none">Opening</x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text sortIcon="none">Current</x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-action/>
            </x-slot:table_header>

            <!-- Table Body ------------------------------------------------------------------------------------------->

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)

                   <x-aaran-ui::table.row>
                        <x-aaran-ui::table.cell-text>{{$index+1}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text>{{$row->ledger_group->vname}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text left>{{$row->vname}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text>{{$row->opening}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text>{{$row->current}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-action id="{{$row->id}}"/>
                    </x-aaran-ui::table.row>

                @endforeach

            </x-slot:table_body>

        </x-aaran-ui::table.form>

        <!--Create ---------------------------------------------------------------------------------------------------->

        <x-aaran-ui::forms.create :id="$common->vid">

            <div class="flex flex-col  gap-3">

{{--                <x-aaran-ui::dropdown.wrapper label="Ledger Name" type="ledgerTyped">--}}
{{--                    <div class="relative">--}}

{{--                        <x-aaran-ui::dropdown.input label="Ledger Name*" id="ledger_name"--}}
{{--                                          wire:model.live="ledger_name"--}}
{{--                                          wire:keydown.arrow-up="decrementLedger"--}}
{{--                                          wire:keydown.arrow-down="incrementLedger"--}}
{{--                                          wire:keydown.enter="enterLedger"/>--}}
{{--                        <x-aaran-ui::dropdown.select>--}}

{{--                            @if($ledgerCollection)--}}
{{--                                @forelse ($ledgerCollection as $i => $ledger)--}}
{{--                                    <x-aaran-ui::dropdown.option highlight="{{ $highlightLedger === $i }}"--}}
{{--                                                       wire:click.prevent="setLedger('{{$ledger->vname}}','{{$ledger->id}}')">--}}
{{--                                        {{ $ledger->vname }}--}}
{{--                                    </x-aaran-ui::dropdown.option>--}}
{{--                                @empty--}}
{{--                                    <x-aaran-ui::dropdown.new href="{{ route('ledgerGroups') }}" label="Ledger"/>--}}
{{--                                @endforelse--}}
{{--                            @endif--}}

{{--                        </x-aaran-ui::dropdown.select>--}}
{{--                    </div>--}}
{{--                </x-aaran-ui::dropdown.wrapper>--}}


                <x-aaran-ui::input.floating wire:model="common.vname" label="Name"/>

                <x-aaran-ui::input.lookup-text wire:model="description" label="Desc"/>

                <x-aaran-ui::input.floating wire:model="opening" label="Opening"/>

                <x-aaran-ui::input.floating wire:model.live="opening_date" type="date" label="Opening Date"/>

                <x-aaran-ui::input.floating wire:model="current" label="Current"/>

            </div>

        </x-aaran-ui::forms.create>

     </x-aaran-ui::forms.m-panel>

    <x-aaran-ui::modal.delete/>
</div>
