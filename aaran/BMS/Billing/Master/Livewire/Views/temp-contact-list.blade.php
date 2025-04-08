<div>
    <x-slot name="header">Contacts</x-slot>

    <!-- Top Controls --------------------------------------------------------------------------------------------->

    <x-Ui::forms.m-panel>

        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <!-- Top Controls --------------------------------------------------------------------------------------------->

        <x-Ui::table.caption :caption="'Contacts'">
            {{$list->count()}}
        </x-Ui::table.caption>

        <!-- Table Header --------------------------------------------------------------------------------------------->

        <x-Ui::table.form>

            <x-slot:table_header name="table_header" class="bg-green-600">
                <x-Ui::table.header-serial width="20%"/>

                <x-Ui::table.header-text wire:click="sortBy('vname')" sortIcon="{{$sortAsc}}">
                    Name
                </x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">Mobile</x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">Contact Type</x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">Contact Person</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">GST No</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Outstanding</x-Ui::table.header-text>

                <x-Ui::table.header-action/>

            </x-slot:table_header>

            <!-- Table Body ------------------------------------------------------------------------------------------->

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)
                    <x-Ui::table.row>
{{--                        <x-Ui::table.cell-text><a href="{{route('invReport',[$row->id])}}"> {{$index+1}}</a>--}}
{{--                        </x-Ui::table.cell-text>--}}

{{--                        <x-Ui::table.cell-text left><a href="{{route('contactReport',[$row->id])}}"> {{$row->vname}}</a>--}}
{{--                        </x-Ui::table.cell-text>--}}

{{--                        <x-Ui::table.cell-text><a href="{{route('contactReport',[$row->id])}}"> {{$row->mobile}}</a>--}}
{{--                        </x-Ui::table.cell-text>--}}

{{--                        <x-Ui::table.cell-text>--}}
{{--                            <a href="{{route('contactReport',[$row->id])}}" class="{{$row->contact_type == 'Debtor'?:'text-orange-400'}}">--}}
{{--                                {{$row->contact_type}}--}}
{{--                            </a>--}}
{{--                        </x-Ui::table.cell-text>--}}

{{--                        <x-Ui::table.cell-text><a--}}
{{--                                href="{{route('contactReport',[$row->id])}}"> {{$row->contact_person}}</a>--}}
{{--                        </x-Ui::table.cell-text>--}}

{{--                        <x-Ui::table.cell-text><a--}}
{{--                                href="{{route('contactReport',[$row->id])}}"> {{$row->gstin}}</a>--}}
{{--                        </x-Ui::table.cell-text>--}}

{{--                        <x-Ui::table.cell-text>--}}
{{--                            <a--}}
{{--                                href="{{route('contactReport',[$row->id])}}"> {{$row->opening_balance+$row->outstanding}}</a>--}}
{{--                        </x-Ui::table.cell-text>--}}


                        <!--We should change this after creating all the routes juz like upper code-->

                        <x-Ui::table.cell-text> {{$index+1}}</x-Ui::table.cell-text>

                        <x-Ui::table.cell-text left> {{$row->vname}}</x-Ui::table.cell-text>

                        <x-Ui::table.cell-text> {{$row->mobile}}</x-Ui::table.cell-text>

                        <x-Ui::table.cell-text> {{$row->contact_type->vname}} </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text>{{$row->contact_person}}</x-Ui::table.cell-text>

                        <x-Ui::table.cell-text>{{$row->gstin}}</x-Ui::table.cell-text>

                        <x-Ui::table.cell-text>{{$row->opening_balance+$row->outstanding}}</x-Ui::table.cell-text>

                        <td class="max-w-max print:hidden">
                            <div class="flex justify-center items-center sm:gap-4 gap-2 px-1 self-center">
                                <a href="{{route('contacts.upsert',[$row->id])}}" class="pt-1">
                                    <x-Ui::button.edit/>
                                </a>
                                <x-Ui::button.delete wire:click="confirmDelete({{$row->id}})"/>
                            </div>
                        </td>
                    </x-Ui::table.row>
                @endforeach

            </x-slot:table_body>

        </x-Ui::table.form>

        <x-Ui::modal.delete/>

        <!-- Actions ------------------------------------------------------------------------------------------->

{{--<div>{{$list->links()}}</div>--}}


    </x-Ui::forms.m-panel>
</div>
