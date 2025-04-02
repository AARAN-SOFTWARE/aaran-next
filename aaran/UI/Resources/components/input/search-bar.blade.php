@props([
    'label' => '',
])
<div class="flex items-center sm:w-9/12 space-x-2 group">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
             aria-hidden="true"
             class=" size-6 text-gray-400 focus:text-blue-600">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
        </svg>
    <div class="relative w-full ">

        <input {{$attributes}} type="Search" id="floating_outlined"
               class="block px-2.5 pb-2.5 pt-4 sm:w-full w-[250px] text-sm text-gray-900  bg-transparent rounded-lg border-1 border-gray-300 appearance-none
            focus:outline-none focus:ring-0 focus:border-blue-600 peer "
               placeholder=" " autocomplete="off"/>

        <label for="floating_outlined"
               class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4
           scale-75 top-2 z-10 origin-[0]
           bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600  peer-placeholder-shown:scale-100
           peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2
           peer-focus:scale-75 peer-focus:-translate-y-4
           rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">{{$label}}</label>
        {{--    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"--}}
        {{--         aria-hidden="true"--}}
        {{--         class="absolute left-3 bottom-0.5 size-5 -translate-y-1/2 text-slate-700/50 dark:text-slate-300/50 group-focus:hidden">--}}
        {{--        <path stroke-linecap="round" stroke-linejoin="round"--}}
        {{--              d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>--}}
        {{--    </svg>--}}
    </div>
</div>
