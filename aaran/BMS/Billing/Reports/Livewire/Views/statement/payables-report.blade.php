<div>
    <x-slot name="header">Payables</x-slot>

    <!------Top Controls ---------------------------------------------------------------------------------------------->
    <x-aaran-ui::forms.m-panel>
        <div class="space-y-16 text-xs">
            <div class="flex md:flex-row flex-col md:justify-between w-full gap-3 my-10">

                <!------Create Record ------------------------------------------------------------------------------------->

                <div class="sm:w-[40rem]">
                    <x-aaran-ui::input.model-select wire:model.live="byParty" :label="'Party Name'">
                        <option value="">choose</option>
                        @foreach($contacts as $contact)
                            <option value="{{$contact->id}}">{{$contact->vname}}</option>
                        @endforeach
                    </x-aaran-ui::input.model-select>
                </div>

                <x-aaran-ui::input.model-date wire:model.live="start_date" :label="'From Date'"/>

                <x-aaran-ui::input.model-date wire:model.live="end_date" :label="'To Date'"/>

                <div class="">
                    <x-aaran-ui::button.print-x wire:click="print"/>
                </div>

            </div>
            <!------Table Header ------------------------------------------------------------------------------------------>
            <x-aaran-ui::table.form>
                <x-slot:table_header name="table_header">
                    <x-aaran-ui::table.header-serial width="20%"/>
                    <x-aaran-ui::table.header-text :sort-icon="'none'">Type</x-aaran-ui::table.header-text>
                    <x-aaran-ui::table.header-text :sort-icon="'none'">Date</x-aaran-ui::table.header-text>
                    <x-aaran-ui::table.header-text :sort-icon="'none'">Invoice Amount</x-aaran-ui::table.header-text>
                    <x-aaran-ui::table.header-text :sort-icon="'none'">Payment Amount</x-aaran-ui::table.header-text>
                    <x-aaran-ui::table.header-text :sort-icon="'none'">Balance</x-aaran-ui::table.header-text>
                </x-slot:table_header>

                <!------Table Body ---------------------------------------------------------------------------------------->

                <x-slot:table_body name="table_body">

                    @php
                        $totalpurchase = 0+$opening_balance;
                        $totalpayment = 0;
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

                    <!------Table Data ------------------------------------------------------------------------------------>

                    @forelse ($list as $index =>  $row)
                        @php
                            $totalpurchase += floatval($row->grand_total);
                            $totalpayment += floatval($row->transaction_amount);
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
                                {{  $balance  = $totalpurchase-$totalpayment}}
                            </x-aaran-ui::table.cell-text>

                        </x-aaran-ui::table.row>

                    @empty
                    @endforelse

                    <!----- Totals ---------------------------------------------------------------------------------------->

                    <x-aaran-ui::table.row>
                        <x-aaran-ui::table.cell-text colspan="3" class="text-md text-right text-gray-400 ">&nbsp;TOTALS&nbsp;&nbsp;&nbsp;
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text
                            class="text-right  text-md ">{{$totalpurchase+$opening_balance}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text class="text-right  text-md ">{{ $totalpayment}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text></x-aaran-ui::table.cell-text>
                    </x-aaran-ui::table.row>

                    <!------ Balance -------------------------------------------------------------------------------------->

                    <x-aaran-ui::table.row>
                        <x-aaran-ui::table.cell-text colspan="3" class="text-md text-right text-gray-400 ">&nbsp;Balance&nbsp;&nbsp;&nbsp;
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text
                            class="text-right  text-md text-blue-500">{{ $totalpurchase-$totalpayment}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text></x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text></x-aaran-ui::table.cell-text>
                    </x-aaran-ui::table.row>
                </x-slot:table_body>
            </x-aaran-ui::table.form>
        </div>
    </x-aaran-ui::forms.m-panel>
</div>
