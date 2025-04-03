@props([
    'label' => '',
    'enter' => null
])
{{--<input--}}
{{--    {{$attributes}}--}}

{{--    type="search"--}}

{{--    autocomplete="off"--}}
{{--    placeholder="Contact Name.."--}}
{{--    @focus="isTyped = true"--}}
{{--    @keydown.escape.window="isTyped = false"--}}
{{--    @keydown.tab.window="isTyped = false"--}}
{{--    @keydown.enter.prevent="isTyped = false"--}}
{{--    class="block w-full rounded-lg "--}}
{{--/>--}}

<div class="relative font-lex">
    <input {{$attributes}}
           type="search"
{{--           id="floating_outlined"--}}
           autocomplete="off"
           @focus="isTyped = true"
           @keydown.escape.window="isTyped = false"
           @keydown.tab.window="isTyped = false"
           @keydown.enter.prevent="isTyped = false"

           class="block px-2.5 pb-2.5 pt-4 w-full text-xs text-gray-900 bg-transparent rounded-lg border-1
           border-gray-300 appearance-none
            focus:outline-none focus:ring-2
           focus:ring-cyan-50 focus:border-blue-600 peer"
           placeholder=" "/>
    <label for="floating_outlined"
           class="absolute text-xs text-gray-500  duration-300 transform -translate-y-4
           scale-75 top-2 z-10 origin-[0]
           bg-white  px-2 peer-focus:px-2 peer-focus:text-blue-600
           peer-placeholder-shown:scale-100
           peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
           peer-focus:-translate-y-4
           rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1 pointer-events-none">{{$label}}</label>
</div>
