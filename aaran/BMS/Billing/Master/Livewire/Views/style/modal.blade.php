<div>
    <x-Ui::lookup.modal-new>

        <div class="flex flex-col gap-3">

            <div>
                <x-Ui::input.floating wire:model="vname" label="Style Name"/>
                <x-Ui::input.error-text wire:model="vname"/>
            </div>

            <x-Ui::input.floating wire:model="description" label="Description"/>
            <x-Ui::input.floating wire:model="image" label="Image"/>

        </div>

    </x-Ui::lookup.modal-new>
</div>

