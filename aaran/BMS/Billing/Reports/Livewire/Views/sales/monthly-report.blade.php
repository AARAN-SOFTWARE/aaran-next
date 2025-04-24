<div>
    <x-slot name="header">Sales Report</x-slot>
    <x-Ui::forms.m-panel>
        <div x-data="{ open: 1 }" class="flex flex-col items-center w-full">
            <div class="flex items-center mb-4 ">
                <button @click="open = 1"
                        :class="open === 1 ? 'bg-yellow-500 text-white' : 'bg-gray-200 hover:bg-gray-300'"
                        class="px-4 py-2 rounded-l-lg focus:outline-none">
                    Summary
                </button>
                <button @click="open = 2"
                        :class="open === 2 ? 'bg-yellow-500 text-white' : 'bg-gray-200 hover:bg-gray-300'"
                        class="px-4 py-2 focus:outline-none">
                    Monthly Report
                </button>
                <button @click="open = 3"
                        :class="open === 3 ? 'bg-yellow-500 text-white' : 'bg-gray-200 hover:bg-gray-300'"
                        class="px-8 py-2 rounded-r-lg focus:outline-none">
                    All
                </button>
            </div>

            <div x-show="open === 1" class="w-full">
                <div class="space-y-2 w-full">
                    <div class="flex flex-row justify-evenly space-x-3">
                        <div class="w-full">
                            <div class="w-1/2">
                                <x-Ui::input.model-select wire:model.live="year" :label="'Year'">
                                    <option value="">Choose...</option>
                                    @for($year=2017;$year<=\Illuminate\Support\Carbon::now()->format('Y');$year++)
                                        <option value="{{$year}}">{{$year}}</option>
                                    @endfor

                                </x-Ui::input.model-select>
                            </div>
                        </div>
                        <div>
                            <x-Ui::button.print-x wire:click="printSummary">Print</x-Ui::button.print-x>
                        </div>
                    </div>
                    <?php
                    $totalSales = 0;
                    ?>
                    <x-Ui::table.form>
                        <x-slot:table_header name="table_header" class="bg-green-600">
                            <x-Ui::table.header-text sortIcon="none">Month</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">Total Sales</x-Ui::table.header-text>
                        </x-slot:table_header>

                        <!-- Table Body ------------------------------------------------------------------------------------------->

                        <x-slot:table_body name="table_body">
                            @foreach(\Aaran\Assets\Helper\Months::months() as $index=>$row)
                                <x-Ui::table.row>
                                    <x-Ui::table.cell-text>
                                        <button wire:click="monthlyReport({{$index+1}})"
                                                @click="setTimeout(()=>open = 2,1500)">{{$row}}</button>
                                    </x-Ui::table.cell-text>
                                    <x-Ui::table.cell-text>
                                        <button wire:click="monthlyReport({{$index+1}})"
                                                @click="setTimeout(()=>open = 2,1500)">{{\Aaran\BMS\Billing\Reports\Livewire\Class\Sales\MonthlyReport::monthlySales($index+1)}}</button>
                                    </x-Ui::table.cell-text>
                                </x-Ui::table.row>
                                    <?php
                                    $totalSales += \Aaran\BMS\Billing\Reports\Livewire\Class\Sales\MonthlyReport::monthlySales($index + 1);
                                    ?>
                            @endforeach
                            <x-Ui::table.row>
                                <x-Ui::table.cell-text right>Total</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text>{{\Aaran\Assets\Helper\ConvertTo::rupeesFormat($totalSales)}}</x-Ui::table.cell-text>
                            </x-Ui::table.row>
                        </x-slot:table_body>

                    </x-Ui::table.form>
                </div>
            </div>

            <div x-show="open === 2" class="w-full" x-cloak>
                <div class="space-y-2 w-full">
                    <div class="flex flex-row justify-evenly space-x-3">
                        <div class="w-full">

                            <x-Ui::input.model-select wire:model.live="month" :label="'Month'">
                                <option value="">Choose...</option>
                                @foreach(\Aaran\Assets\Helper\Months::months() as $index=>$row)
                                    <option value="{{$index+1}}">{{$row}}</option>
                                @endforeach
                            </x-Ui::input.model-select>
                        </div>
                        <div class="w-full">
                            <x-Ui::input.model-select wire:model.live="year" :label="'Year'">
                                <option value="">Choose...</option>
                                @for($year=2017;$year<=\Illuminate\Support\Carbon::now()->format('Y');$year++)
                                    <option value="{{$year}}">{{$year}}</option>
                                @endfor

                            </x-Ui::input.model-select>
                        </div>
                        <div>
                            <x-Ui::button.print-x wire:click="printMonthly">Print</x-Ui::button.print-x>
                        </div>
                    </div>
                    <?php
                    $invoiceTotal = 0;
                    $taxableValueTotal = 0;
                    $gstTotal = 0;
                    $CGSTTotal = 0;
                    ?>

                    <x-Ui::table.form>
                        <x-slot:table_header name="table_header" class="bg-green-600">
                            <x-Ui::table.header-serial width="20%"/>
                            <x-Ui::table.header-text sortIcon="none">GSTIN NO</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">Party Name</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">Bill No</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">Date</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">Invoice Amount
                            </x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">Taxable Value</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">CGST %</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">CGST TAX</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">SGST %</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">SGST TAX</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">IGST %</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">IGST TAX</x-Ui::table.header-text>
                        </x-slot:table_header>

                        <!-- Table Body ------------------------------------------------------------------------------------------->

                        <x-slot:table_body name="table_body">
                            @foreach($list as $index=>$row)

                                    <?php
                                    $invoiceTotal += $row['sale']['grand_total'];
                                    $taxableValueTotal += $row['sale']['total_taxable'];
                                    $gstTotal += $row['sale']['sales_type'] == '1' ? $row['sale']['total_gst'] : 0;
                                    $CGSTTotal += $row['sale']['sales_type'] != '1' ? $row['sale']['total_gst'] : 0;
                                    ?>
                                {{--                                {{dd($row['sale']['sales_type'])}}--}}
                                <x-Ui::table.row>
                                    <x-Ui::table.cell-text><a
                                                href="{{ route('sales.upsert',[$row['sale']['id']]) }}"> {{$index+1}}</a>
                                    </x-Ui::table.cell-text>

                                    <x-Ui::table.cell-text left><a
                                                href="{{ route('sales.upsert',[$row['sale']['id']]) }}"> {{$row['contact_gstin']}}</a>
                                    </x-Ui::table.cell-text>
                                    <x-Ui::table.cell-text left><a
                                                href="{{ route('sales.upsert',[$row['sale']['id']]) }}"> {{$row['contact_name']}}</a>
                                    </x-Ui::table.cell-text>
                                    <x-Ui::table.cell-text><a
                                                href="{{ route('sales.upsert',[$row['sale']['id']]) }}"> {{$row['sale']['invoice_no']}}</a>
                                    </x-Ui::table.cell-text>
                                    <x-Ui::table.cell-text><a
                                                href="{{ route('sales.upsert',[$row['sale']['id']]) }}"> {{ date('d-m-Y', strtotime( $row['sale']['invoice_date']))}}</a>
                                    </x-Ui::table.cell-text>
                                    <x-Ui::table.cell-text right><a
                                                href="{{ route('sales.upsert',[$row['sale']['id']]) }}"> {{$row['sale']['grand_total']}}</a>
                                    </x-Ui::table.cell-text>
                                    <x-Ui::table.cell-text right><a
                                                href="{{ route('sales.upsert',[$row['sale']['id']]) }}"> {{$row['sale']['total_taxable']}}</a>
                                    </x-Ui::table.cell-text>
                                    <x-Ui::table.cell-text left><a
                                                href="{{ route('sales.upsert',[$row['sale']['id']]) }}"> {{$row['sale']['sales_type']=='1'?$row['percent']:0}}</a>
                                    </x-Ui::table.cell-text>
                                    <x-Ui::table.cell-text right><a
                                                href="{{ route('sales.upsert',[$row['sale']['id']]) }}"> {{$row['sale']['sales_type']=='1'?$row['sale']['total_gst']/2:0}}</a>
                                    </x-Ui::table.cell-text>
                                    <x-Ui::table.cell-text left><a
                                                href="{{ route('sales.upsert',[$row['sale']['id']]) }}"> {{$row['sale']['sales_type']=='1'?$row['percent']:0}}</a>
                                    </x-Ui::table.cell-text>
                                    <x-Ui::table.cell-text right><a
                                                href="{{ route('sales.upsert',[$row['sale']['id']]) }}"> {{$row['sale']['sales_type']=='1'?$row['sale']['total_gst']/2:0}}</a>
                                    </x-Ui::table.cell-text>
                                    <x-Ui::table.cell-text>
                                        <a href="{{ route('sales.upsert',[$row['sale']['id']]) }}">{{$row['sale']['sales_type']!='1'?$row['percent']:0}}</a>
                                    </x-Ui::table.cell-text>
                                    <x-Ui::table.cell-text right>
                                        <a href="{{ route('sales.upsert',[$row['sale']['id']]) }}">{{$row['sale']['sales_type']!='1'?$row['sale']['total_gst']:0}}</a>
                                    </x-Ui::table.cell-text>
                                </x-Ui::table.row>

                            @endforeach
                            <x-Ui::table.row>
                                <x-Ui::table.cell-text colspan="3">Total</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text></x-Ui::table.cell-text>
                                <x-Ui::table.cell-text></x-Ui::table.cell-text>
                                <x-Ui::table.cell-text>{{\Aaran\Assets\Helper\ConvertTo::rupeesFormat($invoiceTotal)}}</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text>{{\Aaran\Assets\Helper\ConvertTo::rupeesFormat($taxableValueTotal)}}</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text></x-Ui::table.cell-text>
                                <x-Ui::table.cell-text>{{\Aaran\Assets\Helper\ConvertTo::rupeesFormat($gstTotal/2)}}</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text></x-Ui::table.cell-text>
                                <x-Ui::table.cell-text>{{\Aaran\Assets\Helper\ConvertTo::rupeesFormat($gstTotal/2)}}</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text></x-Ui::table.cell-text>
                                <x-Ui::table.cell-text>{{\Aaran\Assets\Helper\ConvertTo::rupeesFormat($CGSTTotal)}}</x-Ui::table.cell-text>
                            </x-Ui::table.row>
                        </x-slot:table_body>
                    </x-Ui::table.form>
                </div>
            </div>

            <div x-show="open === 3" class="w-full" x-cloak>
                <div>
                    <div class="my-2 flex justify-between">
                        <div class="flex sm:h-10 h-7">
                            <select class="bg-gray-100 border-l rounded-l-lg sm:w-36 border-r-0"
                                    wire:model.live="filterField" wire:change="clearFilter">
                                <option value="">Select...</option>
                                <option value="invoice_no"> Invoice NO</option>
                                <option value="invoice_date"> Invoice Date</option>
                                <option value="contact_id"> Party Name</option>
                            </select>
                            @if($filterField=='contact_id')
                                <select wire:model.live="filterValue" class="rounded-r-lg sm:w-96"
                                        wire:keydown.escape="$set('filterValue', '')">
                                    <option value="">Choose...</option>
                                    @foreach($contects as $contact)
                                        <option value="{{$contact->id}}">{{$contact->vname}}</option>
                                    @endforeach
                                </select>
                            @elseif($filterField=='invoice_date')
                                <input type="date" wire:model.live="filterValue" class="rounded-r-lg sm:w-96"
                                       wire:keydown.escape="$set('filterValue', '')">
                            @else
                                <input wire:model.live="filterValue" class="rounded-r-lg sm:w-96"
                                       wire:keydown.escape="$set('filterValue', '')">
                            @endif
                        </div>
                        <x-Ui::button.new-x wire:click="create"/>

                    </div>

                    <x-Ui::table.form>
                        <x-slot:table_header name="table_header" class="bg-green-600">
                            <x-Ui::table.header-text sortIcon="none">
                                Invoice NO
                            </x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">
                                Invoice Date
                            </x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">Party Name</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">Total Qty</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">Total Taxable
                            </x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">Total Gst</x-Ui::table.header-text>
                            <x-Ui::table.header-text sortIcon="none">Grand Total</x-Ui::table.header-text>
                        </x-slot:table_header>

                        <!-- Table Body ------------------------------------------------------------------------------------------->

                        <x-slot:table_body name="table_body">
                            @foreach($salesAll as $index=>$row)
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

                                    <x-Ui::table.cell-text right>
                                        <a href="{{route('sales.upsert',[$row->id])}}"> {{$row->total_qty}}</a>
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
                                </x-Ui::table.row>
                            @endforeach
                        </x-slot:table_body>
                    </x-Ui::table.form>
                </div>
            </div>
        </div>

    </x-Ui::forms.m-panel>
</div>
