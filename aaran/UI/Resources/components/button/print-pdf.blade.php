@props([
    'routes' => '/'
])

<a href="{{$routes}}" target="_blank"
   class="relative group text-gray-500 transition-colors duration-200 dark:hover:text-violet-500
        dark:text-gray-300 hover:text-violet-600 focus:outline-none animate group pt-1">
    <x-Ui::icons.icon-fill iconfill="print"
                       class="w-5 h-5 fill-gray-600 group-hover:fill-violet-500"/>
    <div class="absolute invisible group-hover:visible -top-9 -right-1">
        <div class="bg-violet-600 text-white text-xs px-2 py-1 rounded-md">
            Print
        </div>
        <div
            class="absolute left-[18px] w-0 h-0 border-l-[5px] border-l-transparent border-t-[7.5px]
            border-t-violet-600 border-r-[5px] border-r-transparent"></div>
    </div>
</a>
