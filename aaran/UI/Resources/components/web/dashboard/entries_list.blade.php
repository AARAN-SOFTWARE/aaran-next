@props(
    [
        'entry' => '',
        'invoice' => '',
        'date' => '',
        'amount' => '',
        'color' => 'text-gray-600',
    ]
)

<div class="flex items-center justify-between p-3 border-b border-gray-200 hover:bg-[#FFFFF0]">
    <div class=" w-3/12 flex-col flex gap-y-2 justify-center items-center">
        <div class="w-10 h-10">
            {{ $slot }}
        </div>
        <div class="text-center font-semibold {{$color}} text-xs" {{$attributes}}>{{ $entry }}</div>
    </div>
    <div class="w-3/12 text-center">
        <span class="text-xs font-semibold ">
            {{ $invoice }}
        </span>
        <div class="text-xs text-gray-600">
            {{ $date }}
        </div>
    </div>
    <span class="w-3/12 text-sm font-semibold text-green-600 text-center">
        {{ $amount }}
    </span>
</div>
