<div>
    <x-slot name="header">Sales</x-slot>

    <x-Ui::forms.m-panel>
        <x-Ui::alerts.notification/>

        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <x-Ui::table.caption :caption="'Sales'">
            {{$list->count()}}
        </x-Ui::table.caption>

        <?php
        $qty = 0;
        $taxable = 0;
        $gst = 0;
        $grand_total = 0;
        ?>

        <x-Ui::table.form>

            <x-slot:table_header name="table_header">
                <x-Ui::table.header-text wire:click="sortBy('invoice_no')" sortIcon="{{$sortAsc}}">
                    Invoice No
                </x-Ui::table.header-text>
                <x-Ui::table.header-text wire:click="sortBy('invoice_no')" sortIcon="{{$sortAsc}}">
                    Invoice Date
                </x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none"> Party Name</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Total Qty</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Total Taxable</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Total Gst</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Grand Total</x-Ui::table.header-text>

                @if(\Aaran\Assets\Features\SaleEntry::hasEinvoice())
                    <x-Ui::table.header-text sortIcon="none">E-Invoice</x-Ui::table.header-text>
                @endif

                @if(\Aaran\Assets\Features\SaleEntry::hasEway()||\Aaran\Assets\Features\SaleEntry::hasEinvoice())
                    <x-Ui::table.header-text sortIcon="none" class="w-28">E-Generate</x-Ui::table.header-text>
                @endif

                <x-Ui::table.header-text sortIcon="none">Print</x-Ui::table.header-text>
                <x-Ui::table.header-action/>
            </x-slot:table_header>

            <x-slot:table_body name="table_body">
                @foreach($list as $index=>$row)

                        <?php
                        $qty += $row->total_qty;
                        $taxable += $row->total_taxable;
                        $gst += $row->total_gst;
                        $grand_total += $row->grand_total;
                        ?>

                    <x-Ui::table.row>

                        <x-Ui::table.cell-text>
                            <a href="{{route('sales.upsert',[$row->id])}}"> {{$row->invoice_no}}</a>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text>
                            <a href="{{route('sales.upsert',[$row->id])}}"> {{ date('d-m-Y', strtotime( $row->invoice_date))}}</a>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text left>
                            <a href="{{route('sales.upsert',[$row->id])}}"> {{$row->contact->vname}}</a>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text>
                            <a href="{{route('sales.upsert',[$row->id])}}"> {{$row->total_qty+0}}</a>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text right>
                            <a href="{{route('sales.upsert',[$row->id])}}"> {{$row->total_taxable}}</a>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text right>
                            <a href="{{route('sales.upsert',[$row->id])}}"> {{$row->total_gst}}</a>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text right>
                            <a href="{{route('sales.upsert',[$row->id])}}"> {{$row->grand_total}}</a>
                        </x-Ui::table.cell-text>

                        @if(\Aaran\Assets\Features\SaleEntry::hasEinvoice())
                            <x-Ui::table.cell-text>
                                {{--                                <a href="{{route('sales.upsert',[$row->id])}}">--}}
                                {{--                                        <?php--}}
                                {{--                                        $obj = \Aaran\BMS\Billing\Entries\Models\Sale::Irn($row->id);--}}
                                {{--                                        ?>--}}
                                {{--                                    @if(isset($obj))--}}
                                {{--                                        @if($obj->status=='Generated')--}}
                                {{--                                            <div--}}
                                {{--                                                class="inline-flex items-center px-3 py-1 rounded-xl gap-x-2 bg-emerald-100/60 ">--}}
                                {{--                                                <span class="h-1.5 w-1.5  rounded-full bg-emerald-500 "></span>--}}
                                {{--                                                <h2 class="font-normal text-emerald-500">{{$obj->status}}--}}
                                {{--                                                </h2>--}}
                                {{--                                            </div>--}}
                                {{--                                        @elseif($obj->status=='Canceled')--}}
                                {{--                                            <div--}}
                                {{--                                                class="inline-flex items-center px-3 py-1 rounded-xl gap-x-2 bg-red-100/60 ">--}}
                                {{--                                                <span class="h-1.5 w-1.5  rounded-full bg-red-500 "></span>--}}
                                {{--                                                <h2 class="font-normal text-red-500 ">{{$obj->status}}--}}
                                {{--                                                </h2>--}}
                                {{--                                            </div>--}}
                                {{--                                        @endif--}}
                                {{--                                    @else--}}
                                {{--                                        <div--}}
                                {{--                                            class="inline-flex items-center px-3 py-1 rounded-xl gap-x-2 bg-purple-100/60 ">--}}
                                {{--                                        <span--}}
                                {{--                                            class="h-1.5 w-1.5  rounded-full bg-purple-500 "></span>--}}
                                {{--                                            <h2 class="font-normal text-purple-500 ">--}}
                                {{--                                                Not-Generated--}}
                                {{--                                            </h2>--}}
                                {{--                                        </div>--}}
                                {{--                                    @endif--}}
                                {{--                                </a>--}}
                            </x-Ui::table.cell-text>
                        @endif

                        @if(\Aaran\Assets\Features\SaleEntry::hasEway()||\Aaran\Assets\Features\SaleEntry::hasEinvoice())
                            <x-Ui::table.cell-text>
                                <div class="inline-flex items-center gap-x-4">
                                    @if(\Aaran\Assets\Features\SaleEntry::hasEinvoice())
                                        {{--                                        <x-Ui::button.e-inv routes="{{route('sales.einvoice',[$row->id]) }}"/>--}}
                                        {{--                                        <x-Ui::button.e-way routes="{{ route('sales.eway',[$row->id]) }}"/>--}}
                                    @endif
                                    @if(\Aaran\Assets\Features\SaleEntry::hasEway())
                                        {{--                                        <x-Ui::button.e-way routes="{{ route('sales.eway',[$row->id]) }}"/>--}}
                                    @endif
                                </div>
                            </x-Ui::table.cell-text>


                        @endif

                        <x-Ui::table.cell-text>
                            <x-Ui::button.print-pdf routes="{{route('sales.print', [$row->id])}}"/>
                        </x-Ui::table.cell-text>

                        <td class="max-w-max print:hidden">
                            <div class="flex justify-center items-center">
                                <a href="{{route('sales.upsert',[$row->id])}}" class="pt-1 px-1.5">
                                    <x-Ui::button.edit/>
                                </a>
                                <x-Ui::button.delete wire:click="confirmDelete({{$row->id}})"/>

                            </div>
                        </td>

                        {{--                        <x-table.cell-text>--}}
                        {{--                            <div class="flex items-center justify-center w-full print:hidden">--}}
                        {{--                                <div class="relative inline-block cursor-pointer group max-w-fit min-w-fit">--}}
                        {{--                                    <a href="{{route('sales.upsert',[$row->id])}}"--}}
                        {{--                                       class="flex text-xl text-center text-gray-600 truncate">--}}
                        {{--                                        <div--}}
                        {{--                                            class="absolute hidden group-hover:block pr-0.5 whitespace-nowrap top-1 w-full">--}}
                        {{--                                            <div class="flex flex-col items-center justify-start -translate-y-full">--}}
                        {{--                                                <div--}}
                        {{--                                                    class="px-3 py-1 text-base text-white bg-blue-500 rounded-lg shadow-md cursor-default">--}}
                        {{--                                                    Edit--}}
                        {{--                                                </div>--}}
                        {{--                                                <div--}}
                        {{--                                                    class="w-0 h-0 border-l-[12px] border-r-[12px] border-t-[8px] border-l-transparent border-r-transparent--}}
                        {{--                                                    border-t-blue-500 -mt-[1px]"></div>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <x-button.link>&nbsp;--}}
                        {{--                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
                        {{--                                                 stroke-width="1.5" stroke="currentColor" class="w-5 h-5">--}}
                        {{--                                                <path stroke-linecap="round" stroke-linejoin="round"--}}
                        {{--                                                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>--}}
                        {{--                                            </svg>--}}
                        {{--                                        </x-button.link>--}}
                        {{--                                    </a>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="relative inline-block cursor-pointer group max-w-fit min-w-fit">--}}
                        {{--                                    <x-button.link wire:click="getDelete({{$row->id}})">&nbsp;--}}
                        {{--                                        <div--}}
                        {{--                                            class="absolute hidden group-hover:block pr-0.5 whitespace-nowrap top-1 w-full">--}}
                        {{--                                            <div class="flex flex-col items-center justify-start -translate-y-full">--}}
                        {{--                                                <div--}}
                        {{--                                                    class="px-3 py-1 text-base text-white bg-red-500 rounded-lg shadow-md cursor-default">--}}
                        {{--                                                    delete--}}
                        {{--                                                </div>--}}
                        {{--                                                <div--}}
                        {{--                                                    class="w-0 h-0 border-l-[12px] border-r-[12px] border-t-[8px] border-l-transparent border-r-transparent border-t-red-500 -mt-[1px]"></div>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
                        {{--                                             stroke-width="1.5" stroke="currentColor" class="w-5 h-5">--}}
                        {{--                                            <path stroke-linecap="round" stroke-linejoin="round"--}}
                        {{--                                                  d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>--}}
                        {{--                                        </svg>--}}
                        {{--                                    </x-button.link>--}}
                        {{--                                </div>--}}
                        {{--                                <div>--}}
                        {{--                                    <x-dropdown.icon>--}}
                        {{--                                        <div class="hover:bg-gray-100 hover:text-violet-600 hover:font-bold">--}}
                        {{--                                            <a href="{{ route('sales.einvoice',[$row->id]) }}">E-Incoice</a>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="hover:bg-gray-100 hover:text-rose-600 hover:font-bold">--}}
                        {{--                                            <a href="{{ route('sales.eway',[$row->id]) }}">E-Way Bill</a>--}}
                        {{--                                        </div>--}}
                        {{--                                    </x-dropdown.icon>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </x-table.cell-text>--}}
                    </x-Ui::table.row>
                @endforeach
                <x-Ui::table.row>
                    <x-Ui::table.cell-text right colspan="3">
                        <span class="font-bold">Total</span>
                    </x-Ui::table.cell-text>
                    <x-Ui::table.cell-text>
                        <span class="font-bold">{{$qty}}</span>
                    </x-Ui::table.cell-text>
                    <x-Ui::table.cell-text right>
                            <span class="font-bold">
                                {{\Aaran\Assets\Helper\ConvertTo::decimal2($taxable)}}
                            </span>
                    </x-Ui::table.cell-text>
                    <x-Ui::table.cell-text right>
                            <span class="font-bold">
                                {{\Aaran\Assets\Helper\ConvertTo::decimal2($gst)}}
                            </span>
                    </x-Ui::table.cell-text>
                    <x-Ui::table.cell-text right>
                            <span class="text-lg font-bold text-green-500">
                                {{\Aaran\Assets\Helper\ConvertTo::decimal2($grand_total)}}
                            </span>
                    </x-Ui::table.cell-text>
                </x-Ui::table.row>

            </x-slot:table_body>

        </x-Ui::table.form>

        <!-- Delete Modal --------------------------------------------------------------------------------------------->
        <x-Ui::modal.confirm-delete/>

        <!-- Actions ------------------------------------------------------------------------------------------->

        <div class="">{{ $list->links() }}</div>

    </x-Ui::forms.m-panel>

</div>
