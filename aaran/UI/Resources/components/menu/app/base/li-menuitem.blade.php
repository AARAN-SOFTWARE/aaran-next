@props(['routes','label'])

<li class="bg-gray-900 mt-0.5 ">
    <a href="{{ route($routes) }}"
       class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-700
                                   text-gray-500 hover:text-gray-200 border-l-4 border-transparent hover:border-green-500 pr-6 pl-6 group">
      <x-Ui::icons.icon-fill iconfill="list-menu" class="w-4 h-auto block fill-gray-500 group-hover:fill-green-500"/>
        <span
            class="ml-2 font-semibold text-sm tracking-wide truncate font-sans">
            {{\Livewire\str($label)->ucfirst()}}
        </span>
    </a>
</li>
