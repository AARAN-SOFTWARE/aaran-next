@props([
    'hover' => 'hover:bg-yellow-50'
])

<tr {{$attributes->merge(['class' => $hover])}}>
    {{$slot}}
</tr>
