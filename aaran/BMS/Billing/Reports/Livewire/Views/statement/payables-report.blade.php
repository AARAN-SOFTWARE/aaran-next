<div>
    <x-slot name="header">Payables</x-slot>

    <!------Top Controls ---------------------------------------------------------------------------------------------->
    <x-Ui::forms.m-panel>
        <div class="space-y-16 text-xs">
            <div class="flex md:flex-row flex-col md:justify-between w-full gap-3 my-10">

                <!------Create Record ------------------------------------------------------------------------------------->

                <div class="sm:w-[40rem]">
                    <x-Ui::input.model-select wire:model.live="byParty" :label="'Party Name'">
                        <option value="">choose</option>
                        @foreach($contacts as $contact)
                            <option value="{{$contact->id}}">{{$contact->vname}}</option>
                        @endforeach
                    </x-Ui::input.model-select>
                </div>

                <x-Ui::input.model-date wire:model.live="start_date" :label="'From Date'"/>

                <x-Ui::input.model-date wire:model.live="end_date" :label="'To Date'"/>

                <div class="">
                    <x-Ui::button.print-x wire:click="print"/>
                </div>

            </div>
            <!------Table Header ------------------------------------------------------------------------------------------>
            <x-Ui::table.form>
                <x-slot:table_header name="table_header">
                    <x-Ui::table.header-serial width="20%"/>
                    <x-Ui::table.header-text :sort-icon="'none'">Type</x-Ui::table.header-text>
                    <x-Ui::table.header-text :sort-icon="'none'">Date</x-Ui::table.header-text>
                    <x-Ui::table.header-text :sort-icon="'none'">Invoice Amount</x-Ui::table.header-text>
                    <x-Ui::table.header-text :sort-icon="'none'">Payment Amount</x-Ui::table.header-text>
                    <x-Ui::table.header-text :sort-icon="'none'">Balance</x-Ui::table.header-text>
                </x-slot:table_header>

                <!------Table Body ---------------------------------------------------------------------------------------->

                <x-slot:table_body name="table_body">

                    @php
                        $totalpurchase = 0+$opening_balance;
                        $totalpayment = 0;
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

                    <!------Table Data ------------------------------------------------------------------------------------>

                    @forelse ($list as $index =>  $row)
                        @php
                            $totalpurchase += floatval($row->grand_total);
                            $totalpayment += floatval($row->transaction_amount);
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
                                {{  $balance  = $totalpurchase-$totalpayment}}
                            </x-Ui::table.cell-text>

                        </x-Ui::table.row>

                    @empty
                    @endforelse

                    <!----- Totals ---------------------------------------------------------------------------------------->

                    <x-Ui::table.row>
                        <x-Ui::table.cell-text colspan="3" class="text-md text-right text-gray-400 ">&nbsp;TOTALS&nbsp;&nbsp;&nbsp;
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text
                            class="text-right  text-md ">{{$totalpurchase+$opening_balance}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text class="text-right  text-md ">{{ $totalpayment}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text></x-Ui::table.cell-text>
                    </x-Ui::table.row>

                    <!------ Balance -------------------------------------------------------------------------------------->

                    <x-Ui::table.row>
                        <x-Ui::table.cell-text colspan="3" class="text-md text-right text-gray-400 ">&nbsp;Balance&nbsp;&nbsp;&nbsp;
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text
                            class="text-right  text-md text-blue-500">{{ $totalpurchase-$totalpayment}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text></x-Ui::table.cell-text>
                        <x-Ui::table.cell-text></x-Ui::table.cell-text>
                    </x-Ui::table.row>
                </x-slot:table_body>
            </x-Ui::table.form>
        </div>
    </x-Ui::forms.m-panel>
</div>
