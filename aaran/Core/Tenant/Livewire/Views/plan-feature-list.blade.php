<div>
    <x-slot name="header">Plan Features</x-slot>
    <x-Ui::forms.m-panel>
        <x-Ui::alerts.notification/>


        <!-- Top Controls --------------------------------------------------------------------------------------------->
        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <!-- Table Caption -------------------------------------------------------------------------------------------->
        <x-Ui::table.caption :caption="'Plan Features'">
            {{$list->count()}}
        </x-Ui::table.caption>

        <!-- Table Data ----------------------------------------------------------------------------------------------->

        <x-Ui::table.form>
            <x-slot:table_header>
                <x-Ui::table.header-serial/>
                <x-Ui::table.header-text sortIcon="none">Plan</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Feature</x-Ui::table.header-text>
                <x-Ui::table.header-status/>
                <x-Ui::table.header-action/>
            </x-slot:table_header>

            <x-slot:table_body>
                @foreach($list as $index=>$row)
                    <x-Ui::table.row>
                        <x-Ui::table.cell-text>{{$index+1}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->plan->vname}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->feature->vname}}</x-Ui::table.cell-text>
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
                    <x-Ui::input.floating-dropdown
                        wire:model="plan_id"
                        label="Plan"
                        id="plan_id"
                        :options="$plans"
                        placeholder="Choose a Plan.."
                    />
                    <x-Ui::input.error-text wire:model="plan_id"/>
                </div>


                <div>
                    <x-Ui::input.floating-dropdown
                        wire:model="feature_id"
                        label="Feature"
                        id="feature_id"
                        :options="$features"
                        placeholder="Choose a Feature.."
                    />
                    <x-Ui::input.error-text wire:model="feature_id"/>
                </div>

            </div>
        </x-Ui::forms.create>


    </x-Ui::forms.m-panel>
</div>
