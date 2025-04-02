@props([
    'id'=>null,
])
<td class=" print:hidden ">
    <div class="flex justify-center items-center px-2 gap-3 self-center">
       <x-Ui::button.edit wire:click="edit({{$id}})"/>
        <x-Ui::button.delete wire:click="confirmDelete({{$id}})"/>
    </div>
</td>
