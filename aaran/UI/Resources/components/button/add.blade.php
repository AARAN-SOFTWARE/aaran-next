<button
    class="w-16 py-2 relative rounded group overflow-hidden font-medium  cursor-pointer
    bg-emerald-500 inline-block text-center" {{$attributes}}>
                <span
                    class="absolute top-0 left-0 flex h-full w-0 mr-0 transition-all
                    duration-500 ease-out transform translate-x-0 bg-emerald-600 group-hover:w-full opacity-90"></span>
    <span class="relative block group-hover:hidden group-hover:text-white text-white  font-semibold">Add</span>
    <span
        class="relative hidden group-hover:block group-hover:text-white text-green-800 left-3">
      <x-Ui::icons.add/>
    </span>
</button>
