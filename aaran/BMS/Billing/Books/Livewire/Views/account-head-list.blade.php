<div>
    <x-slot name="header">Account Heads</x-slot>

    <!-- Top Controls ------------------------------------------------------------------------------------------------->

    <x-aaran-ui::forms.m-panel>
        <x-aaran-ui::alerts.notification />


        <x-aaran-ui::forms.top-controls :show-filters="$showFilters"/>

        <x-aaran-ui::table.caption :caption="'Account Heads'">
            {{$list->count()}}
        </x-aaran-ui::table.caption>

         <x-aaran-ui::table.form>

            <!-- Table Header ----------------------------------------------------------------------------------------->

            <x-slot:table_header name="table_header" class="bg-green-600">
                <x-aaran-ui::table.header-serial width="20%"/>

                <x-aaran-ui::table.header-text wire:click.prevent="sortBy('vname')" sortIcon="{{$getListForm->sortAsc}}">
                    Name
                </x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text sortIcon="none">Opening</x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text sortIcon="none">Current</x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-action/>
            </x-slot:table_header>

            <!-- Table Body ------------------------------------------------------------------------------------------->

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)

                   <x-aaran-ui::table.row>
                        <x-aaran-ui::table.cell-text>{{$index+1}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text left>{{$row->vname}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text>{{$row->opening}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text>{{$row->current}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-action id="{{$row->id}}"/>
                    </x-aaran-ui::table.row>

                @endforeach

            </x-slot:table_body>

        </x-aaran-ui::table.form>

        <!--Create ---------------------------------------------------------------------------------------------------->

        <x-aaran-ui::forms.create :id="$common->vid">

            <div class="flex flex-col  gap-3">
                <x-aaran-ui::input.floating wire:model="common.vname" label="Name"/>

                <x-aaran-ui::input.lookup-text wire:model="description" label="Desc"/>

                <x-aaran-ui::input.floating wire:model="opening" label="Opening"/>

                <x-aaran-ui::input.floating wire:model.live="opening_date" type="date" label="Opening Date"/>

                <x-aaran-ui::input.floating wire:model="current" label="Current"/>

            </div>

        </x-aaran-ui::forms.create>

     </x-aaran-ui::forms.m-panel>

    <x-aaran-ui::modal.delete/>

</div>
