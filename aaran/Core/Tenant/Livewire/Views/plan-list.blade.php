<div>
    <x-slot name="header">Plan</x-slot>
    <x-Ui::forms.m-panel>
        <x-Ui::alerts.notification/>


        <!-- Top Controls --------------------------------------------------------------------------------------------->
        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <!-- Table Caption -------------------------------------------------------------------------------------------->
        <x-Ui::table.caption :caption="'Plan'">
            {{$list->count()}}
        </x-Ui::table.caption>

        <!-- Table Data ----------------------------------------------------------------------------------------------->

        <x-Ui::table.form>
            <x-slot:table_header>
                <x-Ui::table.header-serial/>
                <x-Ui::table.header-text wire:click.prevent="sortBy('vname')" sortIcon="{{$sortAsc}}" :left="true">
                    Plan
                </x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">Price</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Billing Cycle</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Description</x-Ui::table.header-text>

                <x-Ui::table.header-status/>
                <x-Ui::table.header-action/>
            </x-slot:table_header>

            <x-slot:table_body>
                @foreach($list as $index=>$row)
                    <x-Ui::table.row>
                        <x-Ui::table.cell-text>{{$index+1}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->vname}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->price}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->billing_cycle}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->description}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-status active="{{$row->active_id}}"/>
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
            <div class="flex flex-col h-fit gap-3">
                <div>
                    <x-Ui::input.floating wire:model="vname" label="Name"/>
                    <x-Ui::input.error-text wire:model="vname"/>
                </div>

                <div>
                    <x-Ui::input.floating wire:model="price" label="Price"/>
                    <x-Ui::input.error-text wire:model="price"/>
                </div>

                <div>
                    <x-Ui::input.floating-dropdown
                        wire:model="billing_cycle"
                        label="Billing Cycle"
                        id="billing_cycle"
                        :options="['monthly' => 'Monthly', 'yearly' => 'Yearly']"
                        placeholder="Choose a billing cycle"
                    />
                    <x-Ui::input.error-text wire:model="billing_cycle"/>
                </div>

                <div>
                    <x-Ui::input.floating-textarea wire:model="description" label="Description"/>
                </div>

            </div>
        </x-Ui::forms.create>


    </x-Ui::forms.m-panel>
</div>
