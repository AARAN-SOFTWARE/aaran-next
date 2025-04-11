@props([
'message'=>'',
])

<div>
    @error($attributes->whereStartsWith('wire:model')->first()) <span class="text-xs py-2 px-3 text-red-500">{{ $message }}</span> @enderror
</div>
