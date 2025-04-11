<div>

    <x-slot name="header">Ledger Group</x-slot>

    <!-- Top Controls ------------------------------------------------------------------------------------------------->

    <x-Ui::forms.m-panel>

        {{--        <x-Ui::alerts.notification />--}}


        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <x-Ui::table.caption :caption="'Ledger Group'">
            {{$list->count()}}
        </x-Ui::caption>

        <x-Ui::table.form>

            <!-- Table Header ----------------------------------------------------------------------------------------->

            <x-slot:table_header name="table_header" class="bg-green-600">
                <x-Ui::table.header-serial width="20%"/>

                <x-Ui::table.header-text sortIcon="none">Accounts</x-Ui::table.header-text>

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
                        <x-Ui::table.cell-text>{{$row->account_head->vname}}</x-Ui::table.cell-text>
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

            <div class="flex flex-col  gap-3">


                <div>
                    <x-Ui::input.floating autofocus wire:model="vname" label="Ledger Group"/>
                    <x-Ui::input.error-text wire:model="vname"/>
                </div>


                <x-Ui::dropdown.wrapper label="Account Name" type="accountTyped">
                    <div class="relative">

                        <x-Ui::dropdown.input label="Account Head" id="account_name"
                                              wire:model.live="account_name"
                                              wire:keydown.arrow-up="decrementAccount"
                                              wire:keydown.arrow-down="incrementAccount"
                                              wire:keydown.enter="enterAccount"/>
                        <x-Ui::dropdown.select>

                            @if($accountCollection)
                                @forelse ($accountCollection as $i => $account)
                                    <x-Ui::dropdown.option highlight="{{ $highlightAccount === $i }}"
                                                           wire:click.prevent="setAccount('{{$account->vname}}','{{$account->id}}')">
                                        {{ $account->vname }}
                                    </x-Ui::dropdown.option>
                                @empty
                                    <x-Ui::dropdown.new href="{{ route('accountHeads') }}" label="Account"/>
                                @endforelse
                            @endif

                        </x-Ui::dropdown.select>
                    </div>
                    <x-Ui::input.error-text wire:model="account_head_id"/>
                </x-Ui::dropdown.wrapper>

                <x-Ui::input.lookup-text wire:model="desc" label="Desc"/>

                <x-Ui::input.floating wire:model="opening" label="Opening"/>

                <x-Ui::input.floating wire:model.live="opening_date" type="date" label="Opening Date"/>

                <x-Ui::input.floating wire:model="current" label="Current"/>

            </div>

        </x-Ui::forms.create>

    </x-Ui::forms.m-panel>

    <x-Ui::modal.delete/>

</div>
