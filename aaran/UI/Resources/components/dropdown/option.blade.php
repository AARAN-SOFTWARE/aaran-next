@props([
    'highlight' => null
])
<li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-zinc-100 text-blue-900 h-fit ml-2 mr-2
rounded-md text-xs my-1 {{$highlight ? 'bg-blue-100' : ''}} "
    {{$attributes}} x-on:click="isTyped = false">
    {{$slot}}
</li>
{{--<a role="button"--}}
{{--   class="w-full inline-flex items-center gap-x-3 px-4 py-2  text-blue-600 border-t border-b border-gray-300px-2 hover:bg-blue-100" {{$attributes}}>--}}
{{--    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">--}}
{{--        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />--}}
{{--    </svg>--}}
{{--    <span>New {{$label}}</span>--}}
{{--</a>--}}
