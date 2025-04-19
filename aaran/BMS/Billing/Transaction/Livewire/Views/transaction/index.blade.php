<div>
    <x-slot name="header">Transactions</x-slot>

    <x-Ui::forms.m-panel>
        <x-Ui::alerts.notification/>

        <!-- Top Controls --------------------------------------------------------------------------------------------->
        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <!-- Table Caption -------------------------------------------------------------------------------------------->
        <x-Ui::table.caption :caption="$accountBookName">
            {{$list->count()}}
        </x-Ui::table.caption>

        <!-- Table Data ----------------------------------------------------------------------------------------------->

        <x-Ui::table.form>
            <x-slot:table_header>
                <x-Ui::table.header-serial/>
                <x-Ui::table.header-text class="w-[7rem]" wire:click.prevent="sortBy('id')" sortIcon="{{$sortAsc}}"
                                         :left="true">
                    Date
                </x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">Ac Book</x-Ui::table.header-text>
                <x-Ui::table.header-text class="w-[7rem]" sortIcon="none">Mode</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Party</x-Ui::table.header-text>
                <x-Ui::table.header-text class="w-[12rem]" sortIcon="none">Payment Method</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Receipt</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Payment</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Balance</x-Ui::table.header-text>
                <x-Ui::table.header-action/>
            </x-slot:table_header>


            <x-slot:table_body>

                @php
                    $current_balance = $openingBalance;
                    $total_debit = 0;
                    $total_credit = 0;
                @endphp


                    <!-- Opening Balance Row  ----------------------------------------------------------------------------->
                <x-Ui::table.row>
                    @if($openingBalance != null)
                        <x-Ui::table.cell-text :colspan="4" right class="bg-gray-50">
                            &nbsp;
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text left>
                            <strong> Opening Balance</strong>
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text class="bg-gray-50">&nbsp;</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text class="bg-gray-50">&nbsp;</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text class="bg-gray-50">&nbsp;</x-Ui::table.cell-text>

                        <x-Ui::table.cell-text right>
                            {{ \Aaran\Assets\Helper\Format::Decimal($openingBalance) }}
                        </x-Ui::table.cell-text>
                    @endif
                </x-Ui::table.row>


                @foreach($list as $index=>$row)
                    <x-Ui::table.row>
                        <x-Ui::table.cell-text>{{$row->vch_no}}</x-Ui::table.cell-text>

                        <x-Ui::table.cell-text left>
                            {{ date('d-m-Y', strtotime( $row->vdate))}}
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text left>{{$row->account_book->vname}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>
                            {{\Aaran\Assets\Enums\TransactionMode::tryFrom($row->transaction_mode)->getName()}}
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->contact->vname}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>
                            {{\Aaran\Assets\Enums\PaymentMethod::tryFrom($row->payment_method)->getName()}}
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text right>
                            @if($row->transaction_mode  == \Aaran\Assets\Enums\TransactionMode::RECEIPT->value)
                                {{\Aaran\Assets\Helper\Format::Decimal($row->amount)}}
                                @php
                                    $current_balance += ($row->amount + 0);
                                    $total_debit += ($row->amount + 0);
                                @endphp
                            @endif
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text right>
                            @if($row->transaction_mode  == \Aaran\Assets\Enums\TransactionMode::PAYMENT->value)
                                {{\Aaran\Assets\Helper\Format::Decimal($row->amount)}}
                                @php
                                    $current_balance -= ($row->amount + 0);
                                    $total_credit += ($row->amount + 0);
                                @endphp
                            @endif
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-text right>
                            {{ \Aaran\Assets\Helper\Format::Decimal($current_balance) }}
                        </x-Ui::table.cell-text>

                        <x-Ui::table.cell-action id="{{$row->id}}"/>
                    </x-Ui::table.row>
                @endforeach

                <!-- Totals Row -->
                <x-Ui::table.row>
                    <x-Ui::table.cell-text colspan="6" class="text-md text-right text-gray-400 ">
                        TOTALS
                    </x-Ui::table.cell-text>
                    <x-Ui::table.cell-text class="text-right text-lg ">
                        {{ $total_debit != 0 ? \Aaran\Assets\Helper\Format::Decimal($total_debit) :'' }}
                    </x-Ui::table.cell-text>
                    <x-Ui::table.cell-text class="text-right text-lg ">
                        {{ $total_credit  != 0 ? \Aaran\Assets\Helper\Format::Decimal($total_credit) :'' }}
                    </x-Ui::table.cell-text>
                    <x-Ui::table.cell-text class="text-right text-lg text-orange-500 ">
                        {{ $current_balance != 0 ? \Aaran\Assets\Helper\Format::Decimal($current_balance) :'' }}
                    </x-Ui::table.cell-text>
                </x-Ui::table.row>

            </x-slot:table_body>
        </x-Ui::table.form>

        <!-- Delete Modal --------------------------------------------------------------------------------------------->
        <x-Ui::modal.confirm-delete/>

        <div class="pt-5">{{ $list->links() }}</div>

        <!-- Create/ Edit Popup --------------------------------------------------------------------------------------->

        <x-Ui::forms.create-tab :id="$vid" :max-width="'6xl'">

            <div class="h-full">

                <!-- Tab Header --------------------------------------------------------------------------------------->
                <x-Ui::tabs.tab-panel>

                    <x-slot name="tabs">
                        <x-Ui::tabs.tab>Mandatory</x-Ui::tabs.tab>
                        <x-Ui::tabs.tab>Detailing</x-Ui::tabs.tab>
                    </x-slot>

                    <x-slot name="content">

                        <!-- Tab 1 ------------------------------------------------------------------------------------>

                        <x-Ui::tabs.content>
                            <div class="flex flex-col gap-3">

                                <div class="flex flex-row gap-4">
                                    <x-Ui::radio.btn wire:model.live="transaction_mode" value="1">Receipt
                                    </x-Ui::radio.btn>
                                    <x-Ui::radio.btn wire:model.live="transaction_mode" value="2">Payment
                                    </x-Ui::radio.btn>
                                    <x-Ui::input.error-text wire:model="transaction_mode"/>
                                </div>

                                <div class="flex justify-between flex-row gap-4">
                                    <div class="w-1/2">
                                        <x-Ui::input.floating wire:model="vch_no" label="Voucher No"/>
                                        <x-Ui::input.error-text wire:model="vch_no"/>
                                    </div>

                                    <div class="w-1/2">
                                        <x-Ui::input.model-date wire:model="vdate" label="Date"/>
                                    </div>
                                </div>

                                <div>
                                    @livewire('master::contact.lookup',['initId' => $contact_id])
                                    <x-Ui::input.error-text wire:model="contact_id"/>
                                </div>

                                <div>
                                    <x-Ui::input.floating-text class="text-3xl font-semibold" wire:model="amount"
                                                               label="Amount"/>
                                    <x-Ui::input.error-text wire:model="amount"/>
                                </div>


                                <x-Ui::input.floating-textarea wire:model="Remarks" label="Remarks"/>
                            </div>
                        </x-Ui::tabs.content>

                        <!-- Tab 2 ------------------------------------------------------------------------------------>

                        <x-Ui::tabs.content>
                            <div class="flex flex-col gap-3">

                                @livewire('common::lookup.payment-method')
                                <x-Ui::input.error-text wire:model="payment_method"/>

                                {{-- CHEQUE & DD --}}
                                @if (
                                    in_array($payment_method, [
                                        \Aaran\Assets\Enums\PaymentMethod::CHEQUE->value,
                                        \Aaran\Assets\Enums\PaymentMethod::DEMAND_DRAFT->value
                                    ])
                                )
                                    <x-Ui::input.floating wire:model="cheque_no" label="Cheque / DD No"/>
                                    <x-Ui::input.floating wire:model="chq_date" label="Cheque / DD Date"/>
                                    @livewire('common::lookup.bank', ['initId' => $instrument_bank_id])
                                    <x-Ui::input.model-date wire:model="deposit_on" label="Deposit On"/>
                                    <x-Ui::input.model-date wire:model="realised_on" label="Realised On"/>
                                @endif

                                {{-- UPI-based methods --}}
                                @if (
                                    in_array($payment_method, [
                                        \Aaran\Assets\Enums\PaymentMethod::UPI->value,
                                        \Aaran\Assets\Enums\PaymentMethod::PhonePe->value,
                                        \Aaran\Assets\Enums\PaymentMethod::GPay->value,
                                        \Aaran\Assets\Enums\PaymentMethod::Paytm->value
                                    ])
                                )
                                    <x-Ui::input.floating wire:model="cheque_no" label="Reference No"/>
                                    <x-Ui::input.floating wire:model="chq_date" label="Transfer Date"/>
                                    @livewire('common::lookup.bank', ['initId' => $instrument_bank_id])
                                @endif

                                {{-- Bank Transfer methods --}}
                                @if (
                                    in_array($payment_method, [
                                        \Aaran\Assets\Enums\PaymentMethod::RTGS->value,
                                        \Aaran\Assets\Enums\PaymentMethod::NEFT->value,
                                        \Aaran\Assets\Enums\PaymentMethod::IMPS->value,
                                        \Aaran\Assets\Enums\PaymentMethod::BANK_TRANSFER->value
                                    ])
                                )
                                    <x-Ui::input.floating wire:model="cheque_no" label="UTR No"/>
                                    <x-Ui::input.floating wire:model="chq_date" label="Transfer Date"/>
                                    @livewire('common::lookup.bank', ['initId' => $instrument_bank_id])
                                    <x-Ui::input.model-date wire:model="deposit_on" label="Deposit On"/>
                                @endif

                                {{-- Card Payments --}}
                                @if (
                                    in_array($payment_method, [
                                        \Aaran\Assets\Enums\PaymentMethod::CREDIT_CARD->value,
                                        \Aaran\Assets\Enums\PaymentMethod::DEBIT_CARD->value
                                    ])
                                )
                                    <x-Ui::input.floating wire:model="cheque_no" label="Transaction No"/>
                                    <x-Ui::input.floating wire:model="chq_date" label="Transaction Date"/>
                                    @livewire('common::lookup.bank', ['initId' => $instrument_bank_id])
                                @endif

                                {{-- Default for CASH or fallback --}}
                                @if ($payment_method == \Aaran\Assets\Enums\PaymentMethod::CASH->value)
                                    <x-Ui::input.floating wire:model="cheque_no" label="Remarks"/>
                                @endif

                            </div>
                        </x-Ui::tabs.content>

                    </x-slot>
                </x-Ui::tabs.tab-panel>
            </div>
        </x-Ui::forms.create-tab>


    </x-Ui::forms.m-panel>
</div>
