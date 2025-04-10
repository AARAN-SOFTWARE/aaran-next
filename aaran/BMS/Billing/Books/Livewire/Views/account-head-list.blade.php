<div>
    <x-slot name="header">Account Heads</x-slot>

    <!-- Top Controls ------------------------------------------------------------------------------------------------->

    <x-Ui::forms.m-panel>

        <x-Ui::alerts.notification />


        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <x-Ui::table.caption :caption="'Account Heads'">
            {{$list->count()}}
        </x-Ui::table.caption>

         <x-Ui::table.form>

            <!-- Table Header ----------------------------------------------------------------------------------------->

            <x-slot:table_header name="table_header" class="bg-green-600">
                <x-Ui::table.header-serial width="20%"/>

                <x-Ui::table.header-text wire:click.prevent="sortBy('vname')" sortIcon="{{$sortAsc}}">
                    Name
                </x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">Opening</x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">Current</x-Ui::table.header-text>

                <x-Ui::table.header-action/>
            </x-slot:table_header>

            <!-- Table Body ------------------------------------------------------------------------------------------->

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)

                   <x-Ui::table.row>
                        <x-Ui::table.cell-text>{{$index+1}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->vname}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->opening}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->current}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-action id="{{$row->id}}"/>
                    </x-Ui::table.row>

                @endforeach

            </x-slot:table_body>

        </x-Ui::table.form>

        <!--Create ---------------------------------------------------------------------------------------------------->

        <x-Ui::forms.create :id="$vid">

            <div class="flex flex-col gap-3">
                <div>
                    <x-Ui::input.floating wire:model="vname" label="Name"/>
                    <x-Ui::input.error-text wire:model="vname"/>
                </div>

                    <x-Ui::input.lookup-text wire:model="desc" label="Desc"/>

                    <x-Ui::input.floating wire:model="opening" label="Opening"/>

                    <x-Ui::input.floating wire:model.live="opening_date" type="date" label="Opening Date"/>

                    <x-Ui::input.floating wire:model="current" label="Current"/>
            </div>


        </x-Ui::forms.create>

     </x-Ui::forms.m-panel>

    <x-Ui::modal.delete/>

</div>
