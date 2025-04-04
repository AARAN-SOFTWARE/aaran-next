<div x-show="isTyped"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     x-cloak class="">
    <div class="absolute z-20 w-full my-2">
        <div class="block py-2 shadow-md w-full
                                rounded-lg border-transparent flex-1 appearance-none border
                                 bg-white text-gray-800 ring-1 ring-blue-600">
            <ul class="overflow-y-scroll h-44 text-xs">
                {{$slot}}
            </ul>
{{--            <a role="button"--}}
{{--               class=" w-full inline-flex items-center gap-x-3 px-4 py-2  text-blue-600 border-t border-b border-gray-300px-2 hover:bg-blue-100" {{$attributes}}>--}}
{{--                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">--}}
{{--                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />--}}
{{--                </svg>--}}
{{--                <span>New {{$label}}</span>--}}
{{--            </a>--}}
        </div>
    </div>
</div>
