<div>
    <x-slot name="header">Stock List</x-slot>
    <x-Ui::forms.m-panel>

        <x-Ui::loadings.loading/>

        <x-Ui::alerts.notification/>

        <!-- Top Controls --------------------------------------------------------------------------------------------->
        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <!-- Table Caption -------------------------------------------------------------------------------------------->
        <x-Ui::table.caption :caption="'City'">
            {{--            {{$list->count()}}--}}
        </x-Ui::table.caption>

        <!-- Table Data ----------------------------------------------------------------------------------------------->

        <x-Ui::table.form>
            <x-slot:table_header>
                <x-Ui::table.header-serial/>
                <x-Ui::table.header-text sortIcon="none" :left="true">Item code</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none" :left="true">Item Name</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none" :left="true">Warehouse</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none" :left="true">Item group</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none" :left="true">Opening Qty</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none" :left="true">Opening Val</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none" :left="true">Balance Qty</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none" :left="true">Balance Value</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none" :left="true">Value Rate</x-Ui::table.header-text>
            </x-slot:table_header>

            <x-slot:table_body>

                @if($stockData)

                    @foreach ($list['message']['result'] as $row)
                        <x-Ui::table.row>

                            @if (isset($row['item_code']))
                                <x-Ui::table.cell-text>{{ $loop->iteration }}</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text>{{ $row['item_code'] }}</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text left>{{ $row['item_name'] ?? '' }}</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text>{{ $row['warehouse'] ?? '' }}</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text>{{ $row['item_group'] ?? '' }}</x-Ui::table.cell-text>

                                <x-Ui::table.cell-text>{{ $row['opening_qty'] ?? 0 }}</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text right>{{ $row['opening_val'] ?? 0 }}</x-Ui::table.cell-text>

                                <x-Ui::table.cell-text>{{ $row['bal_qty'] ?? 0 }}</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text right>{{ $row['bal_val'] ?? 0 }}</x-Ui::table.cell-text>
                                <x-Ui::table.cell-text right>{{ $row['val_rate'] ?? 0 }}</x-Ui::table.cell-text>
                            @endif
                        </x-Ui::table.row>
                    @endforeach

                @endif
            </x-slot:table_body>
        </x-Ui::table.form>

        {{--        <div class="pt-5">{{ $list->links() }}</div>--}}

        <!-- Create/ Edit Popup --------------------------------------------------------------------------------------->

        <x-Ui::forms.create :id="$vid">
            <x-Ui::input.floating wire:model="vname" label="City Name"/>
            <x-Ui::input.error-text wire:model="vname"/>
        </x-Ui::forms.create>

    </x-Ui::forms.m-panel>
</div>
