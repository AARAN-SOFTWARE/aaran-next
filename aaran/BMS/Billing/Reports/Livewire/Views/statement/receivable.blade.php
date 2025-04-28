<div>
    <x-slot name="header">Receivable</x-slot>

    <!-- Top Controls --------------------------------------------------------------------------------------------->

    <x-Ui::forms.m-panel>

        {{--        <x-forms.top-controls :show-filters="$showFilters"/>--}}

        <!-- Top Controls --------------------------------------------------------------------------------------------->

        <x-Ui::table.caption :caption="'Receivable'">
            {{$list->count()}}
        </x-Ui::table.caption>

        <!-- Table Header --------------------------------------------------------------------------------------------->

        <x-Ui::table.form>

            <x-slot:table_header name="table_header" class="bg-green-600">
                <x-Ui::table.header-serial width="20%"/>

                <x-Ui::table.header-text wire:click="sortBy('vname')" sortIcon="{{$getListForm->sortAsc}}">
                    Name
                </x-Ui::table.header-text>


                <x-Ui::table.header-text sortIcon="none">Contact Type</x-Ui::table.header-text>


                <x-Ui::table.header-text sortIcon="none">Outstanding</x-Ui::table.header-text>

                {{--                <x-table.header-action/>--}}

            </x-slot:table_header>

            <!-- Table Body ------------------------------------------------------------------------------------------->

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)
                        <x-Ui::table.row>
                            <x-Ui::table.cell-text>
                                <a href="{{route('receivables-report',[$row->id])}}"> {{$index+1}}</a>
                            </x-Ui::table.cell-text>

                            <x-Ui::table.cell-text left>
                                <a href="{{route('receivables-report',[$row->id])}}"> {{$row->vname}}</a>
                            </x-Ui::table.cell-text>
                            <x-Ui::table.cell-text>
                                <a
                                    href="{{route('receivables-report',[$row->id])}}"
                                   class="text-blue-600">
                                    {{$row->contact_type->vname}}
                                </a>
                            </x-Ui::table.cell-text>
                            <x-Ui::table.cell-text>
                                <a
                                    href="{{route('receivables-report',[$row->id])}}"> {{$row->opening_balance+$row->outstanding}}
                                </a>
                            </x-Ui::table.cell-text>
                        </x-Ui::table.row>
                @endforeach

            </x-slot:table_body>

        </x-Ui::table.form>

        <!-- Delete Modal --------------------------------------------------------------------------------------------->
        <x-Ui::modal.confirm-delete/>

        <!-- Actions ------------------------------------------------------------------------------------------->

{{--        <div>{{$list->links()}}</div>--}}


    </x-Ui::forms.m-panel>
</div>
