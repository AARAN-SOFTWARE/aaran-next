@props([
    'label' => '',
    'autofocus' => false, // New prop for autofocus
])

<div class="relative w-full">
    <input {{$attributes}} type="text" id="floating_outlined"
           class="block px-2.5 pb-2.5 pt-3 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1
           border-gray-300 appearance-none tracking-wide
           focus:outline-none focus:ring-1 focus:ring-cyan-50 focus:border-blue-400 peer"
           placeholder=" " autocomplete="off"
           @if($autofocus) autofocus @endif />

    <label for="floating_outlined"
           class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300
           transform -translate-y-4 scale-75 top-2 z-10 origin-[0]
           bg-white px-2 peer-focus:px-2 peer-focus:text-blue-400
           peer-focus:dark:text-blue-300 peer-placeholder-shown:scale-100
           peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4
           rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1 pointer-events-none">
        {{$label}}
    </label>
</div>
