<div>
    <div x-data @keydown.tab.stop>
        <x-Ui::lookup.modal :show-modal="$showModal" :height="'h-fit'" :width="'w-2/5'"
                            label="style">
            <div class="flex flex-col gap-3">

                <div>
                    <x-Ui::input.floating wire:model="vname" label="Style Name"/>
                    <x-Ui::input.error-text wire:model="vname"/>
                </div>

                <x-Ui::input.floating wire:model="description" label="Description"/>
                <x-Ui::input.floating wire:model="image" label="Image"/>

            </div>
        </x-Ui::lookup.modal>
    </div>
</div>
