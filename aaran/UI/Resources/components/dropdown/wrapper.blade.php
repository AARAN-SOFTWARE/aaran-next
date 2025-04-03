@props([
    'label' => null,
    'type' => null
])
<div class="xl:flex-col w-full gap-2 font-lex text-xs">
{{--    <label for="contact_name" class="w-[10.3rem] text-zinc-500 tracking-wide py-2">Contact Name</label>--}}
    <div x-data="{isTyped: @entangle('type')}" @click.away="isTyped = false" class="w-full">
        {{$slot}}
    </div>
</div>
