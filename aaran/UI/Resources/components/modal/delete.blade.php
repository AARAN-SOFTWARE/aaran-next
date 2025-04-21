<!-- Delete Record -->
<x-Ui::modal.confirmation wire:model.defer="showDeleteModal">
    <x-slot name="title">Delete Entry</x-slot>
    <x-slot name="content">
        <div class="py-8 text-cool-gray-700 ">Are you sure? This action is irreversible.</div>
    </x-slot>
    <x-slot name="footer">
        <div class=" flex gap-5 justify-end">
            <x-Ui::button.cancel-x wire:click.prevent="$set('showDeleteModal', false)"/>
            <x-Ui::button.danger-x wire:click.prevent="closeDeleteModal()"/>
        </div>
    </x-slot>
</x-Ui::modal.confirmation>
