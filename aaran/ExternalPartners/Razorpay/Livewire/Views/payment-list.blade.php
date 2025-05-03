<div>
    <x-slot name="header">Razorpay Payment List</x-slot>
    <x-Ui::forms.m-panel>
        <x-Ui::alerts.notification />

        <!-- Top Controls --------------------------------------------------------------------------------------------->
        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <!-- Table Data ----------------------------------------------------------------------------------------------->

        <x-Ui::table.form>
            <x-slot:table_header>
                <x-Ui::table.header-serial/>
                <x-Ui::table.header-text  sortIcon="nine" :left="true">Tenant</x-Ui::table.header-text>
                <x-Ui::table.header-text  sortIcon="nine" :left="true">Email</x-Ui::table.header-text>
                <x-Ui::table.header-text  sortIcon="nine" :left="true">Order id</x-Ui::table.header-text>
                <x-Ui::table.header-text  sortIcon="nine" :left="true">Payment Id</x-Ui::table.header-text>
                <x-Ui::table.header-text  sortIcon="nine" :left="true">Signature</x-Ui::table.header-text>
                <x-Ui::table.header-text  sortIcon="nine" :left="true">Amount</x-Ui::table.header-text>
                <x-Ui::table.header-text  sortIcon="nine" :left="true">Method</x-Ui::table.header-text>
                <x-Ui::table.header-text  sortIcon="nine" :left="true">Phone</x-Ui::table.header-text>
                <x-Ui::table.header-status/>
                <x-Ui::table.header-action/>
            </x-slot:table_header>

            <x-slot:table_body>
                @foreach($list as $index=>$row)
                    <x-Ui::table.row>
                        <x-Ui::table.cell-text>{{$index+1}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->tenant->t_name}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->email}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->order_id}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->payment_id}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->signature}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->amount}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->method}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->phone}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->status}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-action id="{{$row->id}}"/>
                    </x-Ui::table.row>
                @endforeach
            </x-slot:table_body>
        </x-Ui::table.form>

        <!-- Delete Modal --------------------------------------------------------------------------------------------->
        <x-Ui::modal.confirm-delete/>

        <div class="pt-5">{{ $list->links() }}</div>

        <!-- Create/ Edit Popup --------------------------------------------------------------------------------------->

        <x-Ui::forms.create :id="$vid">
            <x-Ui::input.floating wire:model="vname" label="City Name" />
            <x-Ui::input.error-text wire:model="vname"/>
        </x-Ui::forms.create>

    </x-Ui::forms.m-panel>
</div>
