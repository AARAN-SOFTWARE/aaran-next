<div>
    <x-slot name="header">Receivables</x-slot>

    <x-aaran-ui::forms.m-panel>
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
            <x-aaran-ui::input.model-date wire:model.live="start_date" :label="'From Date'"/>
            <x-aaran-ui::input.model-date wire:model.live="end_date" :label="'To Date'"/>
            <div class="">
                <x-aaran-ui::button.print-x wire:click="print" />
            </div>
        </div>
        <x-aaran-ui::forms.table>
            <x-slot:table_header name="table_header">
                <x-aaran-ui::table.header-serial width="20%"/>
                <x-aaran-ui::table.header-text :sort-icon="'none'">Type</x-aaran-ui::table.header-text>
                <x-aaran-ui::table.header-text :sort-icon="'none'" >Date</x-aaran-ui::table.header-text>
                <x-aaran-ui::table.header-text :sort-icon="'none'">Invoice Amount</x-aaran-ui::table.header-text>
                <x-aaran-ui::table.header-text :sort-icon="'none'">Receipt Amount</x-aaran-ui::table.header-text>
                <x-aaran-ui::table.header-text :sort-icon="'none'">Balance</x-aaran-ui::table.header-text>
            </x-slot:table_header>
            <x-slot:table_body name="table_body">
                @php
                    $totalSales = 0+$opening_balance;
                    $totalReceipt = 0;
                @endphp
                <x-aaran-ui::table.row>
                    @if($byParty !=null)
                        <x-aaran-ui::table.cell-text colspan="3">
                            <div class="text-right font-bold">
                                Opening Balance
                            </div>
                        </x-aaran-ui::table.cell-text>

                        <x-aaran-ui::table.cell-text colspan="1">
                            <div class="text-right font-bold">
                                {{ $opening_balance}}
                            </div>
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text colspan="1">
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text colspan="1">
                            <div class="text-right font-bold">
                            {{$opening_balance}}
                            </div>
                        </x-aaran-ui::table.cell-text>
                    @endif
                </x-aaran-ui::table.row>
                @forelse ($list as $index =>  $row)
                    @php
                        $totalSales += floatval($row->grand_total);
                        $totalReceipt += floatval($row->transaction_amount);
                    @endphp
                    <x-aaran-ui::table.row>
                        <x-aaran-ui::table.cell-text center>
                            {{ $index + 1 }}
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text center>
                            {{ $row->mode }}
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text left>
                            {{$row->mode=='invoice' ?$row->vno.' / ':''}}{{date('d-m-Y', strtotime($row->vdate))}}
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text right>
                            {{ $row->grand_total }}
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text right>
                            {{ $row->transaction_amount }}
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text right>
                            {{  $balance  = $totalSales-$totalReceipt}}
                        </x-aaran-ui::table.cell-text>
                    </x-aaran-ui::table.row>
                @empty
                @endforelse
                <x-aaran-ui::table.row>
                    <x-aaran-ui::table.cell-text colspan="3" class=" text-md text-right text-gray-400">&nbsp;TOTALS&nbsp;&nbsp;&nbsp;
                    </x-aaran-ui::table.cell-text>
                    <x-aaran-ui::table.cell-text class=" text-right  text-md  text-zinc-500 ">{{$totalSales+$opening_balance}}</x-aaran-ui::table.cell-text>
                    <x-aaran-ui::table.cell-text class=" text-right  text-md  text-zinc-500 ">{{ $totalReceipt}}</x-aaran-ui::table.cell-text>
                    <x-aaran-ui::table.cell-text></x-aaran-ui::table.cell-text>
                </x-aaran-ui::table.row>
                <x-aaran-ui::table.row>
                    <x-aaran-ui::table.cell-text colspan="3" class=" text-md text-right text-gray-400 ">&nbsp;Balance&nbsp;&nbsp;&nbsp;
                    </x-aaran-ui::table.cell-text>
                    <x-aaran-ui::table.cell-text class=" text-right  text-md  text-blue-500 ">{{ $totalSales-$totalReceipt}}</x-aaran-ui::table.cell-text>
                    <x-aaran-ui::table.cell-text class=" text-right  text-md  text-blue-500 "></x-aaran-ui::table.cell-text>
                    <x-aaran-ui::table.cell-text></x-aaran-ui::table.cell-text>
                </x-aaran-ui::table.row>
            </x-slot:table_body>
        </x-aaran-ui::forms.table>
    </x-aaran-ui::forms.m-panel>
</div>
