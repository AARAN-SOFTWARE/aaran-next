<div>
    <div x-data @keydown.tab.stop>
        <x-Ui::lookup.modal :show-modal="$showModal" :height="'h-fit'" :width="'w-2/5'"
                            label="Order No">
            <div>
                <x-Ui::input.floating wire:model="vname" label="Order No"/>
                <x-Ui::input.error-text wire:model="vname"/>
            </div>

            <x-Ui::input.floating wire:model="order_name" label="Order Name"/>

        </x-Ui::lookup.modal>
    </div>
</div>
