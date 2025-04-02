@props([
    'border' => null,
    'bg_color' => null,
    'title' => null,
    'desc' => null,
])

<div class="sm:h-96 flex-col flex justify-center items-center">
    <div class="relative inline-flex items-center justify-center group">
        <span
            class="z-10 absolute sm:bottom-6 bottom-4 sm:right-12 right-8 sm:group-hover:translate-x-11 group-hover:translate-x-6 group-hover:translate-y-3 duration-700 transition-all ease-in-out">
               <div class="sm:w-[135px] sm:h-[135px] w-[88px] h-[88px] rounded-full border-2 {{$border}}"></div>
        </span>
        <span
            class="z-20 {{$bg_color}} sm:w-40 sm:h-40 w-24 h-24 rounded-full flex justify-center items-center cursor-pointer">
                      {{$slot}}
       </span>
    </div>
    <div class="text-2xl font-semibold py-4">{{$title}}</div>
    <div class="text-gray-600 text-sm">{{$desc}}
    </div>
</div>
