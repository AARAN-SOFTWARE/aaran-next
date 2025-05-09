@props([
'icon' => 'wifi',
'colour' => '#000000',
])

<div>
    <button class="border border-gray-300 rounded-xl p-3 bg-white grid grid-rows-2 w-24 h-24 hover:bg-gray-100"
            onclick="copyToClipboard('{{$icon}}')">
        <x-Ui::icons.icon-fill :iconfill="$icon" :colour="$colour" class="block w-8 h-auto"/>

        <h5 class="mt-2 text-xs">{{$icon}}</h5>
    </button>
</div>

