<div>
    <x-slot name="header">Party Report</x-slot>

    <x-aaran-ui::forms.m-panel>
        @php
            $party=\Aaran\BMS\Billing\Master\Models\Contact::find($byParty);
        @endphp

        <div class="space-y-12">
            <div class="flex w-full justify-between gap-x-5">
                <div class="w-1/2 flex gap-5 items-center">

                    <div class="w-full">
                        <x-aaran-ui::input.model-date wire:model.live="start_date" :label="'From Date'"/>
                    </div>
                    <div class="w-full">
                        <x-aaran-ui::input.model-date wire:model.live="end_date" :label="'To Date'"/>
                    </div>
                </div>

                <div class="w-1/2 flex justify-end gap-5 items-center">
                    <div class="">
                        <x-aaran-ui::button.print-x wire:click="print"/>
                    </div>
                    <div>
                        <a href="{{route('contacts')}}">
                            <x-aaran-ui::button.back-x/>
                        </a>
                    </div>
                </div>
            </div>
            <div class=" w-full gap-5 text-start font-merri text-2xl">
                {{$party->vname}}
            </div>
            <x-aaran-ui::table.form>
                <x-slot:table_header name="table_header">
                    <x-aaran-ui::table.header-serial width="20%"/>
                    <x-aaran-ui::table.header-text :sort-icon="'none'" center>Type</x-aaran-ui::table.header-text>
                    <x-aaran-ui::table.header-text :sort-icon="'none'" left>Particulars</x-aaran-ui::table.header-text>
                    <x-aaran-ui::table.header-text :sort-icon="'none'">Credit</x-aaran-ui::table.header-text>
                    <x-aaran-ui::table.header-text :sort-icon="'none'">Debit</x-aaran-ui::table.header-text>
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
                                {{$opening_balance}}
                            </x-aaran-ui::table.cell-text>
                        @endif
                    </x-aaran-ui::table.row>
                    @forelse ($list as $index =>  $row)
                        @php
                            if ($row->mode=='Sales Invoice'){
                                if ($party->contact_type_id==124)
                                {
                                $totalSales += floatval($row->grand_total);}else{$totalSales -= floatval($row->grand_total);}
                                }else{
                                if ($party->contact_type_id==123){
                                $totalSales += floatval($row->grand_total);}else{ $totalSales -= floatval($row->grand_total);}
                                }
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
                                {{$row->mode=='Purchase Invoice'||$row->mode=='Sales Invoice' ?$row->vno.' / ':''}}{{date('d-m-Y', strtotime($row->vdate))}}
                            </x-aaran-ui::table.cell-text>

                            <x-aaran-ui::table.cell-text right>
                                {{ $row->grand_total }}
                            </x-aaran-ui::table.cell-text>

                            <x-aaran-ui::table.cell-text right>
                                {{ $row->transaction_amount }}
                            </x-aaran-ui::table.cell-text>

                            <x-aaran-ui::table.cell-text>
                                {{  $balance  = $totalSales-$totalReceipt}}
                            </x-aaran-ui::table.cell-text>
                        </x-aaran-ui::table.row>
                    @empty
                    @endforelse
                    <x-aaran-ui::table.row>
                        <x-aaran-ui::table.cell-text colspan="3" class=" text-md text-right text-gray-400">&nbsp;TOTALS&nbsp;&nbsp;&nbsp;
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text
                                class=" text-right  text-md  text-zinc-500 ">{{$totalSales+$opening_balance}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text
                                class=" text-right  text-md  text-zinc-500 ">{{ $totalReceipt}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text></x-aaran-ui::table.cell-text>
                    </x-aaran-ui::table.row>
                    <x-aaran-ui::table.row>
                        <x-aaran-ui::table.cell-text colspan="3" class=" text-md text-right text-gray-400 ">&nbsp;Balance&nbsp;&nbsp;&nbsp;
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text
                                class=" text-right  text-md  text-blue-500 ">{{ $totalSales-$totalReceipt}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text
                                class=" text-right  text-md  text-blue-500 "></x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text></x-aaran-ui::table.cell-text>
                    </x-aaran-ui::table.row>
                </x-slot:table_body>
            </x-aaran-ui::table.form>

        </div>
    </x-aaran-ui::forms.m-panel>
</div>
