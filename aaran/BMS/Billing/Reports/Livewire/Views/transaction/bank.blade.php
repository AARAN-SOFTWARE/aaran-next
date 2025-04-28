<div>
    <x-slot name="header">{{$transName}}</x-slot>

    <x-Ui::forms.m-panel>

        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <div class="w-full flex-row flex justify-between gap-x-5">
            <div class="w-full flex-row flex  gap-x-5">
                <div class="w-1/6">
                    <x-Ui::input.floating type="date" wire:model.live="startDate" label="Start Date"/>
                </div>
                <div class="w-1/6">
                    <x-Ui::input.floating type="date" wire:model.live="endDate" label="End Date"/>
                </div>
            </div>

            <div class="">
                <x-Ui::button.print-x wire:click="print"/>
            </div>
        </div>


        {{--            <a href="{{ route('report.print') }}">print--}}
        {{--            </a>--}}


        <x-Ui::table.form>

            <x-slot:table_header name="table_header" class="bg-green-100">
                {{--                <x-table.header-text sort-icon="none">Opening Date</x-table.header-text>--}}
                <x-Ui::table.header-text wire:click.prevent="sortBy ('contact_id')" sort-icon="{{$getListForm->sortAsc}}">
                    VCH NO
                </x-Ui::table.header-text>

                <x-Ui::table.header-text sort-icon="none">Date</x-Ui::table.header-text>

                <x-Ui::table.header-text wire:click.prevent="sortBy ('contact_id')" sort-icon="{{$getListForm->sortAsc}}">
                    Contact
                </x-Ui::table.header-text>

                <x-Ui::table.header-text wire:click.prevent="sortBy('contact_id')"
                                     sort-icon="none">Type
                </x-Ui::table.header-text>

                {{--                <x-table.header-text sort-icon="none">Mode of Payments</x-table.header-text>--}}

                <x-Ui::table.header-text sort-icon="none">Credit</x-Ui::table.header-text>

                <x-Ui::table.header-text sort-icon="none">Debit</x-Ui::table.header-text>

                <x-Ui::table.header-text sort-icon="none">Balance</x-Ui::table.header-text>

            </x-slot:table_header>


            <x-slot:table_body name="table_body">
                <x-Ui::table.row>
                    @if($byParty != null)
                        <x-Ui::table.cell-text :colspan="4" right>
                            &nbsp;
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text :colspan="2" center="">
                            <strong> Opening Balance:</strong>
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text right>
                            <div>
                                {{ $opening_balance }}
                            </div>
                        </x-Ui::table.cell-text>
                    @endif
                </x-Ui::table.row>

                @php
                    $current_balance = $opening_balance; // Initialize current balance with opening balance
                    $total_credit = 0 + $opening_balance; // Initialize total credit
                    $total_debit = 0; // Initialize total debit
                @endphp

                @foreach($list as $index => $row)
                    <x-Ui::table.row>
                        <x-Ui::table.cell-text>{{ $index + 1 }}</x-Ui::table.cell-text>

                        <x-Ui::table.cell-text>{{ date('d-m-Y', strtotime($row->vdate)) }}</x-Ui::table.cell-text>

                        <x-Ui::table.cell-text left>{{ $row->contact->vname }}</x-Ui::table.cell-text>

                        <x-Ui::table.cell-text>{{ \Aaran\Transaction\Models\Transaction::common($row->receipttype_id) }}</x-Ui::table.cell-text>

                        <x-Ui::table.cell-text right>
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
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text right>
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
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text right>
                            {{ $current_balance }} <!-- Display current balance -->
                        </x-Ui::table.cell-text>

                    </x-Ui::table.row>
                @endforeach

                <!-- Totals Row -->
                <x-Ui::table.row>
                    <x-Ui::table.cell-text colspan="4" class="text-md text-right text-gray-400 ">
                        TOTALS
                    </x-Ui::table.cell-text>
                    <x-Ui::table.cell-text class="text-right text-md ">
                        {{ $total_credit }} <!-- Total Credit -->
                    </x-Ui::table.cell-text>
                    <x-Ui::table.cell-text class="text-right text-md ">
                        {{ $total_debit }} <!-- Total Debit -->
                    </x-Ui::table.cell-text>
                    <x-Ui::table.cell-text class="text-right text-md ">
                        {{ $current_balance }} <!-- Total Balance -->
                    </x-Ui::table.cell-text>
                </x-Ui::table.row>

            </x-slot:table_body>


        </x-Ui::table.form>

        <!-- Delete Modal --------------------------------------------------------------------------------------------->
        <x-Ui::modal.confirm-delete/>

        <x-Ui::forms.create :id="$common->vid" :max-width="'6xl'" wire:click="contactUpdate">

            <!-- Receipt & Payment  ----------------------------------------------------------------------------------->

            <div class="flex gap-x-5 gap-y-3">

                <!-- Left Area  --------------------------------------------------------------------------------------->

                <div class="w-1/2 space-y-3">

                    <!-- Party Name ----------------------------------------------------------------------------------->

                    <div class="flex flex-row gap-4">
                        <x-Ui::radio.btn wire:model.live="mode_id" value="111">Receipt</x-Ui::radio.btn>
                        <x-Ui::radio.btn wire:model.live="mode_id" value="110">Payment</x-Ui::radio.btn>
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

                    <x-Ui::dropdown.wrapper label="Contact Name" type="contactTyped">
                        <div class="relative ">

                            <x-Ui::dropdown.input label="Contact Name*" id="contact_name"
                                              wire:model.live="contact_name"
                                              wire:keydown.arrow-up="decrementContact"
                                              wire:keydown.arrow-down="incrementContact"
                                              wire:keydown.enter="enterContact"/>
                            <x-Ui::dropdown.select>

                                @if($contactCollection)
                                    @forelse ($contactCollection as $i => $contact)
                                        <x-Ui::dropdown.option highlight="{{ $highlightContact === $i }}"
                                                           wire:click.prevent="setContact('{{$contact->vname}}','{{$contact->id}}')">
                                            {{ $contact->vname }}
                                        </x-Ui::dropdown.option>
                                    @empty
                                        <x-Ui::dropdown.new href="{{route('contacts.upsert',['0'])}}" label="Contact"/>
                                    @endforelse
                                @endif
                            </x-Ui::dropdown.select>

                        </div>
                    </x-Ui::dropdown.wrapper>

                    <x-Ui::input.floating wire:model="common.vname" :label="'Amount*'"/>

                    <x-Ui::input.model-date wire:model="vdate" :label="'Date'"/>

                    <x-Ui::input.floating wire:model="remarks" :label="'Remarks'"/>

                </div>

                <!-- Right Area  -------------------------------------------------------------------------------------->

                <div class="w-1/2 space-y-3">

                    <x-Ui::tabs.tab-panel>

                        <x-slot name="tabs">
                            <x-Ui::tabs.tab>Instrument</x-Ui::tabs.tab>
                            <x-Ui::tabs.tab>Against</x-Ui::tabs.tab>
                            <x-Ui::tabs.tab>Purpose</x-Ui::tabs.tab>
                            <x-Ui::tabs.tab>Admin</x-Ui::tabs.tab>
                        </x-slot>

                        <x-slot name="content">

                            <!-- Tab 1  ------------------------------------------------------------------------------->

                            <x-Ui::tabs.content>

                                <div class="flex flex-col gap-3">

                                    <!-- receipt type ----------------------------------------------------------------->

                                    {{--                                    @if($trans_type_id == 109)--}}

                                    <x-Ui::dropdown.wrapper label="Type" type="receipt_typeTyped">

                                        <div class="relative ">

                                            <x-Ui::dropdown.input label="Type" id="receipt_type_name"
                                                              wire:model.live="receipt_type_name"
                                                              wire:keydown.arrow-up="decrementReceiptType"
                                                              wire:keydown.arrow-down="incrementReceiptType"
                                                              wire:keydown.enter="enterReceiptType"/>

                                            <x-Ui::dropdown.select>
                                                @if($receipt_typeCollection)
                                                    @forelse ($receipt_typeCollection as $i => $receipt_type)
                                                        <x-Ui::dropdown.option
                                                            highlight="{{$highlightReceiptType === $i  }}"
                                                            wire:click.prevent="setReceiptType('{{$receipt_type->vname}}','{{$receipt_type->id}}')">
                                                            {{ $receipt_type->vname }}
                                                        </x-Ui::dropdown.option>
                                                    @empty
                                                        <x-Ui::dropdown.new
                                                            wire:click.prevent="receiptTypeSave('{{$receipt_type_name}}')"
                                                            label="Receipt"/>
                                                    @endforelse
                                                @endif
                                            </x-Ui::dropdown.select>

                                        </div>

                                    </x-Ui::dropdown.wrapper>
                                    {{--                                    @endif--}}

                                    <!-- bank ------------------------------------------------------------------------->

                                    <x-Ui::dropdown.wrapper label="Instrument Bank" type="instrumentBankTyped">
                                        <div class="relative">
                                            <x-Ui::dropdown.input
                                                label="Instrument Bank"
                                                id="instrument_bank_name"
                                                wire:model.live="instrument_bank_name"
                                                wire:keydown.arrow-up="decrementInstrumentBank"
                                                wire:keydown.arrow-down="incrementInstrumentBank"
                                                wire:keydown.enter="enterInstrumentBank"
                                            />

                                            <x-Ui::dropdown.select>
                                                @if($instrumentBankCollection)
                                                    @forelse ($instrumentBankCollection as $i => $instrumentBank)
                                                        <x-Ui::dropdown.option
                                                            highlight="{{ $highlightInstrumentBank === $i }}"
                                                            wire:click.prevent="setInstrumentBank('{{ $instrumentBank->vname }}', '{{ $instrumentBank->id }}')">
                                                            {{ $instrumentBank->vname }}
                                                        </x-Ui::dropdown.option>
                                                    @empty
                                                        <x-Ui::dropdown.new
                                                            wire:click.prevent="instrumentBankSave('{{ $instrument_bank_name }}')"
                                                            label="Instrument Bank Details"/>
                                                    @endforelse
                                                @endif
                                            </x-Ui::dropdown.select>
                                        </div>
                                    </x-Ui::dropdown.wrapper>

                                    @if($receipt_type_id == 86)
                                        <x-Ui::input.model-date :label="'Chq.Date'"/>
                                        <x-Ui::input.floating wire:model="chq_no" :label="'Chq_no'"/>

                                    @endif

                                    <x-Ui::input.model-date wire:model="deposit_on" :label="'Deposit On'"/>
                                    <x-Ui::input.model-date wire:model="realised_on" :label="'Realised On'"/>

                                </div>

                            </x-Ui::tabs.content>

                            <!-- Tab 2  ------------------------------------------------------------------------------->

                            <x-Ui::tabs.content>

                                <div class="flex flex-col gap-3">

                                    <!-- Order No --------------------------------------------------------------------->

                                    <x-Ui::dropdown.wrapper label="Order NO" type="orderTyped">

                                        <div class="relative">
                                            <x-Ui::dropdown.input label="Order NO" id="order_name"
                                                              wire:model.live="order_name"
                                                              wire:keydown.arrow-up="decrementOrder"
                                                              wire:keydown.arrow-down="incrementOrder"
                                                              wire:keydown.enter="enterOrder"/>

                                            <x-Ui::dropdown.select>
                                                @if($orderCollection)

                                                    @forelse ($orderCollection as $i => $order)

                                                        <x-Ui::dropdown.option highlight="{{$highlightOrder === $i  }}"
                                                                           wire:click.prevent="setOrder('{{$order->vname}}','{{$order->id}}')">
                                                            {{ $order->vname }}
                                                        </x-Ui::dropdown.option>
                                                    @empty
                                                        @livewire('aaran.master.order.lookup.order-model',[$order_name])
                                                    @endforelse
                                                @endif
                                            </x-Ui::dropdown.select>
                                        </div>

                                    </x-Ui::dropdown.wrapper>

                                    <x-Ui::input.floating wire:model="ref_no" :label="'Against'"/>

                                    <x-Ui::input.floating wire:model="ref_amount" :label="'Ref Amount'"/>

                                </div>

                            </x-Ui::tabs.content>

                            <!-- Tab 3  ------------------------------------------------------------------------------->

                            <x-Ui::tabs.content>

                                <div class="flex flex-col gap-3">

                                    <x-Ui::input.floating wire:model="paid_to" :label="'Paid To'"/>

                                    <x-Ui::input.floating wire:model="purpose" :label="'Purpose'"/>

                                </div>

                            </x-Ui::tabs.content>

                            <!-- Tab 4  ------------------------------------------------------------------------------->

                            <x-Ui::tabs.content>
                                <div class="flex flex-col gap-3">
                                    <x-Ui::input.floating wire:model="verified_by" :label="'Verified_by'"/>
                                    <x-Ui::input.model-date wire:model="verified_on" :label="'Verified_On'"/>
                                </div>
                            </x-Ui::tabs.content>

                        </x-slot>
                    </x-Ui::tabs.tab-panel>

                </div>
            </div>
        </x-Ui::forms.create>

    </x-Ui::forms.m-panel>
</div>
