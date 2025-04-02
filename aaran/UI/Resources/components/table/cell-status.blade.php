@props([
    'active'=>1,
])
<td class="border-r px-2 border-neutral-300 text-center text-xs">
    <div
        class="inline-flex items-center px-3 py-1 rounded-xl gap-x-2 @if($active==1)bg-emerald-100/60 @else bg-red-100/60 @endif ">

        <span class="h-1.5 w-1.5  rounded-full @if($active==1)bg-emerald-500 @else bg-red-500 @endif"></span>

        <h2 class=" font-normal @if($active==1)text-emerald-500 @else text-red-500 @endif">@if($active==1)
                Active
            @else
                In-Active
            @endif
        </h2>

    </div>
</td>

