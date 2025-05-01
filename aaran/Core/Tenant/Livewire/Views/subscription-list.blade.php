<div>
    <x-slot name="header">Subscription List</x-slot>
    <x-Ui::forms.m-panel>
        <x-Ui::alerts.notification/>


        <!-- Top Controls --------------------------------------------------------------------------------------------->
        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <!-- Table Caption -------------------------------------------------------------------------------------------->
        <x-Ui::table.caption :caption="'Subscriptions'">
            {{$list->count()}}
        </x-Ui::table.caption>

        <!-- Table Data ----------------------------------------------------------------------------------------------->

        <x-Ui::table.form>
            <x-slot:table_header>
                <x-Ui::table.header-serial/>
                <x-Ui::table.header-text sortIcon="none">Tenant</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Plan</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Started at</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Expires at</x-Ui::table.header-text>
                <x-Ui::table.header-status/>
                <x-Ui::table.header-action/>
            </x-slot:table_header>

            <x-slot:table_body>
                @foreach($list as $index=>$row)
                    <x-Ui::table.row>
                        <x-Ui::table.cell-text>{{$index+1}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->tenant->t_name}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->plan->vname}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{ date('d-m-Y', strtotime( $row->started_at))}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{ date('d-m-Y', strtotime( $row->expires_at))}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->status}}</x-Ui::table.cell-text>
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
                            wire:model="tenant_id"
                            label="Tenant"
                            id="tenant_id"
                            :options="$tenants"
                            placeholder="Choose a Tenant.."
                    />
                    <x-Ui::input.error-text wire:model="tenant_id"/>
                </div>

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
                    <x-Ui::input.model-date wire:model="started_at" label="Started at"/>
                    <x-Ui::input.error-text wire:model="started_at"/>
                </div>

                <div>
                    <x-Ui::input.model-date wire:model="expires_at" label="Expires at"/>
                    <x-Ui::input.error-text wire:model="expires_at"/>
                </div>

                <div>
                    <x-Ui::input.floating-dropdown
                            wire:model="status"
                            label="status"
                            id="status"
                            :options="['active'=>'Active', 'expired'=>'Expired', 'canceled'=>'Canceled', 'trial'=>'Trial',]"
                        placeholder="Choose a status.."
                    />
                    <x-Ui::input.error-text wire:model="status"/>
                </div>

            </div>
        </x-Ui::forms.create>


    </x-Ui::forms.m-panel>
</div>
