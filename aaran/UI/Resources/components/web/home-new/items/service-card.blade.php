@props([
    'title' => null,
    'image' => null,
])
<div class="relative group flex-col flex gap-4">
    <div class="text-center font-semibold sm:text-xl text-md">{{$title}}</div>
    <img src="{{$image}}" alt="" class="brightness-50 h-full w-full">
    <div
        class="sm:w-[60px] sm:h-[60px] w-[40px] h-[40px] absolute top-20 -left-1 invisible group-hover:visible group-hover:translate-x-9
                    group-hover:opacity-90 ease-linear transition-all duration-200 bg-white inline-flex justify-center items-center rounded-md">
        {{$slot}}
    </div>
    <button
        class="absolute bottom-1 left-8 bg-[#F31A49] text-white inline-flex items-center max-w-max px-5 py-4
                    invisible group-hover:visible group-hover:-translate-y-6 font-semibold tracking-wider group-hover:opacity-90 ease-linear transition-all duration-200">
        <span><a href="{{route('services')}}">Read Details</a></span>
        <span>
                        <a href="{{route('services')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-4">
                          <path stroke-linecap="round" stroke-linejoin="round"
                                d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"/>
                        </svg>
                        </a>
                    </span>
    </button>
</div>
