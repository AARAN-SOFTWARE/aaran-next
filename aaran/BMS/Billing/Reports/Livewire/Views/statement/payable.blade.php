<div>
    <x-slot name="header">Payables</x-slot>

    <!-- Top Controls --------------------------------------------------------------------------------------------->

    <x-aaran-ui::forms.m-panel>

        {{--        <x-forms.top-controls :show-filters="$showFilters"/>--}}

        <!-- Top Controls --------------------------------------------------------------------------------------------->

        <x-aaran-ui::table.caption :caption="'PayablesReport'">
            {{$list->count()}}
        </x-aaran-ui::table.caption>

        <!-- Table Header --------------------------------------------------------------------------------------------->

        <x-aaran-ui::table.form>

            <x-slot:table_header name="table_header" class="bg-green-600">
                <x-aaran-ui::table.header-serial width="20%"/>

                <x-aaran-ui::table.header-text wire:click="sortBy('vname')" sortIcon="{{$getListForm->sortAsc}}">
                    Name
                </x-aaran-ui::table.header-text>

                {{--                <x-table.header-text sortIcon="none">Mobile</x-table.header-text>--}}

                <x-aaran-ui::table.header-text sortIcon="none">Contact Type</x-aaran-ui::table.header-text>

                {{--                <x-table.header-text sortIcon="none">Contact Person</x-table.header-text>--}}
                {{--                <x-table.header-text sortIcon="none">GST No</x-table.header-text>--}}
                <x-aaran-ui::table.header-text sortIcon="none">Outstanding</x-aaran-ui::table.header-text>

                {{--                <x-table.header-action/>--}}

            </x-slot:table_header>

            <!-- Table Body ------------------------------------------------------------------------------------------->

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)
                        <x-aaran-ui::table.row>
                            <x-aaran-ui::table.cell-text>
                                <a href="{{route('payables-report',[$row->id])}}"> {{$index+1}}</a>
                            </x-aaran-ui::table.cell-text>

                            <x-aaran-ui::table.cell-text left>
                                <a href="{{route('payables-report',[$row->id])}}"> {{$row->vname}}</a>
                            </x-aaran-ui::table.cell-text>
                            <x-aaran-ui::table.cell-text>
                                <a href="{{route('payables-report',[$row->id])}}"
                                   class="text-orange-600">
                                    {{$row->contact_type->vname}}
                                </a>
                            </x-aaran-ui::table.cell-text>
                            <x-aaran-ui::table.cell-text>
                                <a
                                        href="{{route('payables-report',[$row->id])}}"> {{$row->opening_balance+$row->outstanding}}</a>
                            </x-aaran-ui::table.cell-text>
                        </x-aaran-ui::table.row>
                @endforeach

            </x-slot:table_body>

        </x-aaran-ui::table.form>

        <x-aaran-ui::modal.delete/>

        <!-- Actions ------------------------------------------------------------------------------------------->

{{--        <div>{{$list->links()}}</div>--}}


    </x-aaran-ui::forms.m-panel>
</div>
