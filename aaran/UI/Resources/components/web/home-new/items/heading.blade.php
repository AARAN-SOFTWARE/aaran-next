@props([
    'label' => null
])
<div class="flex items-center gap-x-3 justify-center animate__animated wow bounceInDown"
     data-wow-duration="3s" {{$attributes}}>
    <span class="h-2 px-4 bg-gradient-to-r from-white to-[#070609] ">&nbsp;</span>
    <span class="text-[#070609] sm:text-xl text-xs font-semibold">{{$label}}</span>
    <span class="h-2 px-4 bg-gradient-to-r from-[#070609] to-white">&nbsp;</span>
</div>
