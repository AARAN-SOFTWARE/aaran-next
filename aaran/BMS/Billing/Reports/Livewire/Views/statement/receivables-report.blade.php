<div>
    <x-slot name="header">Receivables</x-slot>

    <x-Ui::forms.m-panel>
        <div class="flex md:flex-row flex-col md:justify-between w-full gap-3">
            <div class="sm:w-[40rem]">
{{--                <x-input.model-select wire:model.live="byParty" :label="'Party Name'">--}}
{{--                    <option value="">choose</option>--}}
{{--                    @foreach($contacts as $contact)--}}
{{--                        <option value="{{$contact->id}}">{{$contact->vname}}</option>--}}
{{--                    @endforeach--}}
{{--                </x-input.model-select>--}}
                <div class="text-lg font-merri space-x-5">
                    <span class="font-lex">Party Name:</span> <span >{{$partyName}}</span>
                </div>
            </div>
            <x-Ui::input.model-date wire:model.live="start_date" :label="'From Date'"/>
            <x-Ui::input.model-date wire:model.live="end_date" :label="'To Date'"/>
            <div class="">
                <x-Ui::button.print-x wire:click="print" />
            </div>
        </div>
        <x-Ui::forms.table>
            <x-slot:table_header name="table_header">
                <x-Ui::table.header-serial width="20%"/>
                <x-Ui::table.header-text :sort-icon="'none'">Type</x-Ui::table.header-text>
                <x-Ui::table.header-text :sort-icon="'none'" >Date</x-Ui::table.header-text>
                <x-Ui::table.header-text :sort-icon="'none'">Invoice Amount</x-Ui::table.header-text>
                <x-Ui::table.header-text :sort-icon="'none'">Receipt Amount</x-Ui::table.header-text>
                <x-Ui::table.header-text :sort-icon="'none'">Balance</x-Ui::table.header-text>
            </x-slot:table_header>
            <x-slot:table_body name="table_body">
                @php
                    $totalSales = 0+$opening_balance;
                    $totalReceipt = 0;
                @endphp
                <x-Ui::table.row>
                    @if($byParty !=null)
                        <x-Ui::table.cell-text colspan="3">
                            <div class="text-right font-bold">
                                Opening Balance
                            </div>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text colspan="1">
                            <div class="text-right font-bold">
                                {{ $opening_balance}}
                            </div>
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text colspan="1">
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text colspan="1">
                            <div class="text-right font-bold">
                            {{$opening_balance}}
                            </div>
                        </x-Ui::table.cell-text>
                    @endif
                </x-Ui::table.row>
                @forelse ($list as $index =>  $row)
                    @php
                        $totalSales += floatval($row->grand_total);
                        $totalReceipt += floatval($row->transaction_amount);
                    @endphp
                    <x-Ui::table.row>
                        <x-Ui::table.cell-text center>
                            {{ $index + 1 }}
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text center>
                            {{ $row->mode }}
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>
                            {{$row->mode=='invoice' ?$row->vno.' / ':''}}{{date('d-m-Y', strtotime($row->vdate))}}
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text right>
                            {{ $row->grand_total }}
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text right>
                            {{ $row->transaction_amount }}
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text right>
                            {{  $balance  = $totalSales-$totalReceipt}}
                        </x-Ui::table.cell-text>
                    </x-Ui::table.row>
                @empty
                @endforelse
                <x-Ui::table.row>
                    <x-Ui::table.cell-text colspan="3" class=" text-md text-right text-gray-400">&nbsp;TOTALS&nbsp;&nbsp;&nbsp;
                    </x-Ui::table.cell-text>
                    <x-Ui::table.cell-text class=" text-right  text-md  text-zinc-500 ">{{$totalSales+$opening_balance}}</x-Ui::table.cell-text>
                    <x-Ui::table.cell-text class=" text-right  text-md  text-zinc-500 ">{{ $totalReceipt}}</x-Ui::table.cell-text>
                    <x-Ui::table.cell-text></x-Ui::table.cell-text>
                </x-Ui::table.row>
                <x-Ui::table.row>
                    <x-Ui::table.cell-text colspan="3" class=" text-md text-right text-gray-400 ">&nbsp;Balance&nbsp;&nbsp;&nbsp;
                    </x-Ui::table.cell-text>
                    <x-Ui::table.cell-text class=" text-right  text-md  text-blue-500 ">{{ $totalSales-$totalReceipt}}</x-Ui::table.cell-text>
                    <x-Ui::table.cell-text class=" text-right  text-md  text-blue-500 "></x-Ui::table.cell-text>
                    <x-Ui::table.cell-text></x-Ui::table.cell-text>
                </x-Ui::table.row>
            </x-slot:table_body>
        </x-Ui::forms.table>
    </x-Ui::forms.m-panel>
</div>
