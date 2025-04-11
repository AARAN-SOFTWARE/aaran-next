<div>
    <x-Ui::lookup.modal-new>

        <div class="flex flex-col gap-3">
            <div>
                <x-Ui::input.floating wire:model="vname" label="Order No"/>
                <x-Ui::input.error-text wire:model="vname"/>
            </div>

            <x-Ui::input.floating wire:model="order_name" label="Order Name"/>
        </div>

    </x-Ui::lookup.modal-new>
</div>

