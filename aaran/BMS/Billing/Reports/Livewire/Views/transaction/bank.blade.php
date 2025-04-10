<div>
    <x-slot name="header">{{$transName}}</x-slot>

    <x-aaran-ui::forms.m-panel>

        <x-aaran-ui::forms.top-controls :show-filters="$showFilters"/>

        <div class="w-full flex-row flex justify-between gap-x-5">
            <div class="w-full flex-row flex  gap-x-5">
                <div class="w-1/6">
                    <x-aaran-ui::input.floating type="date" wire:model.live="startDate" label="Start Date"/>
                </div>
                <div class="w-1/6">
                    <x-aaran-ui::input.floating type="date" wire:model.live="endDate" label="End Date"/>
                </div>
            </div>

            <div class="">
                <x-aaran-ui::button.print-x wire:click="print"/>
            </div>
        </div>


        {{--            <a href="{{ route('report.print') }}">print--}}
        {{--            </a>--}}


        <x-aaran-ui::table.form>

            <x-slot:table_header name="table_header" class="bg-green-100">
                {{--                <x-table.header-text sort-icon="none">Opening Date</x-table.header-text>--}}
                <x-aaran-ui::table.header-text wire:click.prevent="sortBy ('contact_id')" sort-icon="{{$getListForm->sortAsc}}">
                    VCH NO
                </x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text sort-icon="none">Date</x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text wire:click.prevent="sortBy ('contact_id')" sort-icon="{{$getListForm->sortAsc}}">
                    Contact
                </x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text wire:click.prevent="sortBy('contact_id')"
                                     sort-icon="none">Type
                </x-aaran-ui::table.header-text>

                {{--                <x-table.header-text sort-icon="none">Mode of Payments</x-table.header-text>--}}

                <x-aaran-ui::table.header-text sort-icon="none">Credit</x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text sort-icon="none">Debit</x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text sort-icon="none">Balance</x-aaran-ui::table.header-text>

            </x-slot:table_header>


            <x-slot:table_body name="table_body">
                <x-aaran-ui::table.row>
                    @if($byParty != null)
                        <x-aaran-ui::table.cell-text :colspan="4" right>
                            &nbsp;
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text :colspan="2" center="">
                            <strong> Opening Balance:</strong>
                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text right>
                            <div>
                                {{ $opening_balance }}
                            </div>
                        </x-aaran-ui::table.cell-text>
                    @endif
                </x-aaran-ui::table.row>

                @php
                    $current_balance = $opening_balance; // Initialize current balance with opening balance
                    $total_credit = 0 + $opening_balance; // Initialize total credit
                    $total_debit = 0; // Initialize total debit
                @endphp

                @foreach($list as $index => $row)
                    <x-aaran-ui::table.row>
                        <x-aaran-ui::table.cell-text>{{ $index + 1 }}</x-aaran-ui::table.cell-text>

                        <x-aaran-ui::table.cell-text>{{ date('d-m-Y', strtotime($row->vdate)) }}</x-aaran-ui::table.cell-text>

                        <x-aaran-ui::table.cell-text left>{{ $row->contact->vname }}</x-aaran-ui::table.cell-text>

                        <x-aaran-ui::table.cell-text>{{ \Aaran\Transaction\Models\Transaction::common($row->receipttype_id) }}</x-aaran-ui::table.cell-text>

                        <x-aaran-ui::table.cell-text right>
                            @if($row->mode_id == 110)
                                <!-- Credit -->
                                {{$row->vname + 0 }}
                                @php
                                    $current_balance += ($row->vname + 0); // Update balance for credit
                                    $total_credit += ($row->vname + 0); // Accumulate total credit
                                @endphp
                            @else
                                &nbsp; <!-- Empty space for non-credit rows -->
                            @endif
                        </x-aaran-ui::table.cell-text>

                        <x-aaran-ui::table.cell-text right>
                            @if($row->mode_id == 111)
                                <!-- Debit -->
                                {{$row->vname + 0}}
                                @php
                                    $current_balance -= ($row->vname + 0); // Update balance for debit
                                    $total_debit += ($row->vname + 0); // Accumulate total debit
                                @endphp
                            @else
                                &nbsp; <!-- Empty space for non-debit rows -->
                            @endif
                        </x-aaran-ui::table.cell-text>

                        <x-aaran-ui::table.cell-text right>
                            {{ $current_balance }} <!-- Display current balance -->
                        </x-aaran-ui::table.cell-text>

                    </x-aaran-ui::table.row>
                @endforeach

                <!-- Totals Row -->
                <x-aaran-ui::table.row>
                    <x-aaran-ui::table.cell-text colspan="4" class="text-md text-right text-gray-400 ">
                        TOTALS
                    </x-aaran-ui::table.cell-text>
                    <x-aaran-ui::table.cell-text class="text-right text-md ">
                        {{ $total_credit }} <!-- Total Credit -->
                    </x-aaran-ui::table.cell-text>
                    <x-aaran-ui::table.cell-text class="text-right text-md ">
                        {{ $total_debit }} <!-- Total Debit -->
                    </x-aaran-ui::table.cell-text>
                    <x-aaran-ui::table.cell-text class="text-right text-md ">
                        {{ $current_balance }} <!-- Total Balance -->
                    </x-aaran-ui::table.cell-text>
                </x-aaran-ui::table.row>

            </x-slot:table_body>


        </x-aaran-ui::table.form>

        <x-aaran-ui::modal.delete/>

        <x-aaran-ui::forms.create :id="$common->vid" :max-width="'6xl'" wire:click="contactUpdate">

            <!-- Receipt & Payment  ----------------------------------------------------------------------------------->

            <div class="flex gap-x-5 gap-y-3">

                <!-- Left Area  --------------------------------------------------------------------------------------->

                <div class="w-1/2 space-y-3">

                    <!-- Party Name ----------------------------------------------------------------------------------->

                    <div class="flex flex-row gap-4">
                        <x-aaran-ui::radio.btn wire:model.live="mode_id" value="111">Receipt</x-aaran-ui::radio.btn>
                        <x-aaran-ui::radio.btn wire:model.live="mode_id" value="110">Payment</x-aaran-ui::radio.btn>
                    </div>

                    {{--                    <x-input.model-select wire:model.live="account_book_id">--}}
                    {{--                        <option value="" selected>Choose</option>--}}
                    {{--                        @foreach($account_books as $account_book)--}}
                    {{--                            <option value="{{ $account_book->id }}">--}}
                    {{--                                {{ $account_book->vname . ' (ACC-No: ' . $account_book->account_no . ')' }}--}}
                    {{--                            </option>--}}
                    {{--                        @endforeach--}}
                    {{--                    </x-input.model-select>--}}

                    {{--                    <div>hello</div>--}}
                    @if($account_book_id)
                        <div>{{$account_book_id}}</div>
                    @endif
                    @if($opening_bal)
                        <div>
                            <strong>Opening Balance:</strong> {{ $opening_bal}}
                        </div>
                    @endif

                    @if($trans_type_id)
                        <div>
                            <strong>Transaction Type ID:</strong> {{ $trans_type_id }}
                        </div>
                    @endif

                    <x-aaran-ui::dropdown.wrapper label="Contact Name" type="contactTyped">
                        <div class="relative ">

                            <x-aaran-ui::dropdown.input label="Contact Name*" id="contact_name"
                                              wire:model.live="contact_name"
                                              wire:keydown.arrow-up="decrementContact"
                                              wire:keydown.arrow-down="incrementContact"
                                              wire:keydown.enter="enterContact"/>
                            <x-aaran-ui::dropdown.select>

                                @if($contactCollection)
                                    @forelse ($contactCollection as $i => $contact)
                                        <x-aaran-ui::dropdown.option highlight="{{ $highlightContact === $i }}"
                                                           wire:click.prevent="setContact('{{$contact->vname}}','{{$contact->id}}')">
                                            {{ $contact->vname }}
                                        </x-aaran-ui::dropdown.option>
                                    @empty
                                        <x-aaran-ui::dropdown.new href="{{route('contacts.upsert',['0'])}}" label="Contact"/>
                                    @endforelse
                                @endif
                            </x-aaran-ui::dropdown.select>

                        </div>
                    </x-aaran-ui::dropdown.wrapper>

                    <x-aaran-ui::input.floating wire:model="common.vname" :label="'Amount*'"/>

                    <x-aaran-ui::input.model-date wire:model="vdate" :label="'Date'"/>

                    <x-aaran-ui::input.floating wire:model="remarks" :label="'Remarks'"/>

                </div>

                <!-- Right Area  -------------------------------------------------------------------------------------->

                <div class="w-1/2 space-y-3">

                    <x-aaran-ui::tabs.tab-panel>

                        <x-slot name="tabs">
                            <x-aaran-ui::tabs.tab>Instrument</x-aaran-ui::tabs.tab>
                            <x-aaran-ui::tabs.tab>Against</x-aaran-ui::tabs.tab>
                            <x-aaran-ui::tabs.tab>Purpose</x-aaran-ui::tabs.tab>
                            <x-aaran-ui::tabs.tab>Admin</x-aaran-ui::tabs.tab>
                        </x-slot>

                        <x-slot name="content">

                            <!-- Tab 1  ------------------------------------------------------------------------------->

                            <x-aaran-ui::tabs.content>

                                <div class="flex flex-col gap-3">

                                    <!-- receipt type ----------------------------------------------------------------->

                                    {{--                                    @if($trans_type_id == 109)--}}

                                    <x-aaran-ui::dropdown.wrapper label="Type" type="receipt_typeTyped">

                                        <div class="relative ">

                                            <x-aaran-ui::dropdown.input label="Type" id="receipt_type_name"
                                                              wire:model.live="receipt_type_name"
                                                              wire:keydown.arrow-up="decrementReceiptType"
                                                              wire:keydown.arrow-down="incrementReceiptType"
                                                              wire:keydown.enter="enterReceiptType"/>

                                            <x-aaran-ui::dropdown.select>
                                                @if($receipt_typeCollection)
                                                    @forelse ($receipt_typeCollection as $i => $receipt_type)
                                                        <x-aaran-ui::dropdown.option
                                                            highlight="{{$highlightReceiptType === $i  }}"
                                                            wire:click.prevent="setReceiptType('{{$receipt_type->vname}}','{{$receipt_type->id}}')">
                                                            {{ $receipt_type->vname }}
                                                        </x-aaran-ui::dropdown.option>
                                                    @empty
                                                        <x-aaran-ui::dropdown.new
                                                            wire:click.prevent="receiptTypeSave('{{$receipt_type_name}}')"
                                                            label="Receipt"/>
                                                    @endforelse
                                                @endif
                                            </x-aaran-ui::dropdown.select>

                                        </div>

                                    </x-aaran-ui::dropdown.wrapper>
                                    {{--                                    @endif--}}

                                    <!-- bank ------------------------------------------------------------------------->

                                    <x-aaran-ui::dropdown.wrapper label="Instrument Bank" type="instrumentBankTyped">
                                        <div class="relative">
                                            <x-aaran-ui::dropdown.input
                                                label="Instrument Bank"
                                                id="instrument_bank_name"
                                                wire:model.live="instrument_bank_name"
                                                wire:keydown.arrow-up="decrementInstrumentBank"
                                                wire:keydown.arrow-down="incrementInstrumentBank"
                                                wire:keydown.enter="enterInstrumentBank"
                                            />

                                            <x-aaran-ui::dropdown.select>
                                                @if($instrumentBankCollection)
                                                    @forelse ($instrumentBankCollection as $i => $instrumentBank)
                                                        <x-aaran-ui::dropdown.option
                                                            highlight="{{ $highlightInstrumentBank === $i }}"
                                                            wire:click.prevent="setInstrumentBank('{{ $instrumentBank->vname }}', '{{ $instrumentBank->id }}')">
                                                            {{ $instrumentBank->vname }}
                                                        </x-aaran-ui::dropdown.option>
                                                    @empty
                                                        <x-aaran-ui::dropdown.new
                                                            wire:click.prevent="instrumentBankSave('{{ $instrument_bank_name }}')"
                                                            label="Instrument Bank Details"/>
                                                    @endforelse
                                                @endif
                                            </x-aaran-ui::dropdown.select>
                                        </div>
                                    </x-aaran-ui::dropdown.wrapper>

                                    @if($receipt_type_id == 86)
                                        <x-aaran-ui::input.model-date :label="'Chq.Date'"/>
                                        <x-aaran-ui::input.floating wire:model="chq_no" :label="'Chq_no'"/>

                                    @endif

                                    <x-aaran-ui::input.model-date wire:model="deposit_on" :label="'Deposit On'"/>
                                    <x-aaran-ui::input.model-date wire:model="realised_on" :label="'Realised On'"/>

                                </div>

                            </x-aaran-ui::tabs.content>

                            <!-- Tab 2  ------------------------------------------------------------------------------->

                            <x-aaran-ui::tabs.content>

                                <div class="flex flex-col gap-3">

                                    <!-- Order No --------------------------------------------------------------------->

                                    <x-aaran-ui::dropdown.wrapper label="Order NO" type="orderTyped">

                                        <div class="relative">
                                            <x-aaran-ui::dropdown.input label="Order NO" id="order_name"
                                                              wire:model.live="order_name"
                                                              wire:keydown.arrow-up="decrementOrder"
                                                              wire:keydown.arrow-down="incrementOrder"
                                                              wire:keydown.enter="enterOrder"/>

                                            <x-aaran-ui::dropdown.select>
                                                @if($orderCollection)

                                                    @forelse ($orderCollection as $i => $order)

                                                        <x-aaran-ui::dropdown.option highlight="{{$highlightOrder === $i  }}"
                                                                           wire:click.prevent="setOrder('{{$order->vname}}','{{$order->id}}')">
                                                            {{ $order->vname }}
                                                        </x-aaran-ui::dropdown.option>
                                                    @empty
                                                        @livewire('aaran.master.order.lookup.order-model',[$order_name])
                                                    @endforelse
                                                @endif
                                            </x-aaran-ui::dropdown.select>
                                        </div>

                                    </x-aaran-ui::dropdown.wrapper>

                                    <x-aaran-ui::input.floating wire:model="ref_no" :label="'Against'"/>

                                    <x-aaran-ui::input.floating wire:model="ref_amount" :label="'Ref Amount'"/>

                                </div>

                            </x-aaran-ui::tabs.content>

                            <!-- Tab 3  ------------------------------------------------------------------------------->

                            <x-aaran-ui::tabs.content>

                                <div class="flex flex-col gap-3">

                                    <x-aaran-ui::input.floating wire:model="paid_to" :label="'Paid To'"/>

                                    <x-aaran-ui::input.floating wire:model="purpose" :label="'Purpose'"/>

                                </div>

                            </x-aaran-ui::tabs.content>

                            <!-- Tab 4  ------------------------------------------------------------------------------->

                            <x-aaran-ui::tabs.content>
                                <div class="flex flex-col gap-3">
                                    <x-aaran-ui::input.floating wire:model="verified_by" :label="'Verified_by'"/>
                                    <x-aaran-ui::input.model-date wire:model="verified_on" :label="'Verified_On'"/>
                                </div>
                            </x-aaran-ui::tabs.content>

                        </x-slot>
                    </x-aaran-ui::tabs.tab-panel>

                </div>
            </div>
        </x-aaran-ui::forms.create>

    </x-aaran-ui::forms.m-panel>
</div>
