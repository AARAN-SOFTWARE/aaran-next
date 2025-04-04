@props([
    'margin' => ''
])
<div class="w-full border-t-[1px] border-blue-500 rounded-md shadow-lg  {{$margin}}">
    <div {{$attributes->merge(['class' => 'sm:p-5 p-2 bg-white rounded-t-md space-y-4 border border-gray-200 min-h-auto'])}}>
        {{$slot}}
    </div>
</div>
