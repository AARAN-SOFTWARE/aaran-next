@props([
'message'=>'',
])

<div>
    @error($attributes->whereStartsWith('wire:model')->first()) <span class="text-xs text-red-500">{{ $message }}</span> @enderror
</div>
