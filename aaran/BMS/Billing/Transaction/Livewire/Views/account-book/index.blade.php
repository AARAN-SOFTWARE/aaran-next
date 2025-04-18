<div>
    <x-slot name="header">Account Book</x-slot>

    <x-Ui::forms.m-panel>
        <x-Ui::alerts.notification/>

        <!-- Top Controls --------------------------------------------------------------------------------------------->
        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <!-- Table Caption -------------------------------------------------------------------------------------------->
        <x-Ui::table.caption :caption="'Account Book'">
            {{$list->count()}}
        </x-Ui::table.caption>

        <!-- Table Data ----------------------------------------------------------------------------------------------->

        <x-Ui::table.form>
            <x-slot:table_header>
                <x-Ui::table.header-serial/>
                <x-Ui::table.header-text wire:click.prevent="sortBy('id')" sortIcon="{{$sortAsc}}" :left="true">
                    Name
                </x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">Type</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Account No</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Bank</x-Ui::table.header-text>
{{--                <x-Ui::table.header-text sortIcon="none">Opening</x-Ui::table.header-text>--}}
{{--                <x-Ui::table.header-text sortIcon="none">Date</x-Ui::table.header-text>--}}
                <x-Ui::table.header-text sortIcon="none">Balance</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">As on Date</x-Ui::table.header-text>
{{--                <x-Ui::table.header-text sortIcon="none">Last Entry</x-Ui::table.header-text>--}}
                <x-Ui::table.header-status/>
                <x-Ui::table.header-action/>
            </x-slot:table_header>

            <x-slot:table_body>
                @foreach($list as $index=>$row)
                    <x-Ui::table.row>
                        <x-Ui::table.cell-text>{{$index+1}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->vname}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->transaction_type->vname}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->account_no}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->bank->vname}}</x-Ui::table.cell-text>
{{--                        <x-Ui::table.cell-text left>{{$row->opening_balance}}</x-Ui::table.cell-text>--}}
{{--                        <x-Ui::table.cell-text left>{{$row->opening_balance_date}}</x-Ui::table.cell-text>--}}
                        <x-Ui::table.cell-text right>{{$row->current_balance}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->current_balance_date}}</x-Ui::table.cell-text>
{{--                        <x-Ui::table.cell-text left>{{$row->current_entry_id}}</x-Ui::table.cell-text>--}}
                        <x-Ui::table.cell-status active="{{$row->active_id}}"/>
                        <x-Ui::table.cell-action id="{{$row->id}}"/>
                    </x-Ui::table.row>
                @endforeach
            </x-slot:table_body>
        </x-Ui::table.form>

        <!-- Delete Modal --------------------------------------------------------------------------------------------->
        <x-Ui::modal.delete/>

        <div class="pt-5">{{ $list->links() }}</div>

        <!-- Create/ Edit Popup --------------------------------------------------------------------------------------->

        <x-Ui::forms.create :id="$vid">
            <div class="flex flex-col gap-3">

                <div>
                    <x-Ui::input.floating wire:model="vname" label="Account Book Name"/>
                    <x-Ui::input.error-text wire:model="vname"/>
                </div>

                @livewire('common::lookup.transaction-type',['initId' => $transaction_type_id])

                @if (!empty($transaction_type_id) && $transaction_type_id != 1)

                    <x-Ui::input.floating wire:model="account_no" label="Account No"/>

                    <x-Ui::input.floating wire:model="ifsc_code" label="IFSC Code"/>

                    @livewire('common::lookup.bank',['initId' => $bank_id])

                    @livewire('common::lookup.account-type',['initId' => $account_type_id])

                    <x-Ui::input.floating wire:model="branch" label="Branch"/>
                @endif

                <x-Ui::input.floating wire:model="opening_balance" label="Opening Balance"/>

                <x-Ui::input.model-date wire:model="opening_balance_date" label="Opening Date"/>

                <x-Ui::input.floating wire:model="notes" label="notes"/>

            </div>
        </x-Ui::forms.create>

    </x-Ui::forms.m-panel>
</div>
