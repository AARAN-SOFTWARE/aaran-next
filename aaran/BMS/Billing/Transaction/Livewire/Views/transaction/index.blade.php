<div>
    <x-slot name="header">Transactions</x-slot>

    <x-Ui::forms.m-panel>
        <x-Ui::alerts.notification/>

        <!-- Top Controls --------------------------------------------------------------------------------------------->
        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <!-- Table Caption -------------------------------------------------------------------------------------------->
        <x-Ui::table.caption :caption="'Transactions'">
            {{$list->count()}}
        </x-Ui::table.caption>

        <!-- Table Data ----------------------------------------------------------------------------------------------->

        <x-Ui::table.form>
            <x-slot:table_header>
                <x-Ui::table.header-serial/>
                <x-Ui::table.header-text wire:click.prevent="sortBy('id')" sortIcon="{{$sortAsc}}" :left="true">
                    Date
                </x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">Ac Book</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Mode</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Party</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Credit</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Debit</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Balance</x-Ui::table.header-text>
                <x-Ui::table.header-action/>
            </x-slot:table_header>

            <x-slot:table_body>
                @foreach($list as $index=>$row)
                    <x-Ui::table.row>
                        <x-Ui::table.cell-text>{{$row->vch_no}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->vdate}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->account_book_id}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->transaction_mode}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->contact_id}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->payment_method}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text right>{{$row->amount}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->amount}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->amount}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-action id="{{$row->id}}"/>
                    </x-Ui::table.row>
                @endforeach
            </x-slot:table_body>
        </x-Ui::table.form>

        <!-- Delete Modal --------------------------------------------------------------------------------------------->
        <x-Ui::modal.delete/>

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
                                </div>


                                <div class="flex justify-between flex-row gap-4">
                                    <div class="w-1/2">
                                        <x-Ui::input.floating wire:model="vch_no" label="Voucher No"/>
                                    </div>

                                    <div class="w-1/2">
                                        <x-Ui::input.model-date wire:model="vdate" label="Date"/>
                                    </div>
                                </div>

                                @livewire('master::contact.lookup',['initId' => $contact_id])

                                <x-Ui::input.floating-text class="text-3xl font-semibold" wire:model="amount"
                                                           label="Amount"/>

                                <x-Ui::input.floating-textarea wire:model="Remarks" label="Remarks"/>
                            </div>
                        </x-Ui::tabs.content>

                        <!-- Tab 2 ------------------------------------------------------------------------------------>

                        <x-Ui::tabs.content>
                            <div class="flex flex-col gap-3">

                                @livewire('common::lookup.payment-method')

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
