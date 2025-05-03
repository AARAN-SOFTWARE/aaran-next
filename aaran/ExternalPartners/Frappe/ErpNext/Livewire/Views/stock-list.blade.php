<div>
    <x-slot name="header">Stock List</x-slot>

    <x-Ui::forms.m-panel>

        <x-Ui::loadings.loading/>

        <x-Ui::alerts.notification/>

        <!-- Select Dropdown -->
        <select wire:model="selected">
            <option value="Wireless Mouse">Wireless Mouse</option>
            <option value="Keyboard">Keyboards</option>
        </select>

        <!-- Search Button -->
        <button class="px-3 py-2 bg-green-400" wire:click="getStockBalanceReport">
            Search
        </button>

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

                @if (!empty($stockData))
                    @foreach ($stockData as $row)
                        @if (!empty($row['item_code']))
                            <x-Ui::table.row>
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
                            </x-Ui::table.row>
                        @endif
                    @endforeach
                @else
                    <x-Ui::table.row>
                        <x-Ui::table.cell-text colspan="10" class="text-center text-gray-500">
                            No stock data available.
                        </x-Ui::table.cell-text>
                    </x-Ui::table.row>
                @endif

            </x-slot:table_body>
        </x-Ui::table.form>

    </x-Ui::forms.m-panel>
</div>
