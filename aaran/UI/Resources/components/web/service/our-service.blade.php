<div class="w-[90%] p-6 m-auto bg-white overflow-hidden mt-5 h-full flex flex-col">
    <div class="overflow-hidden">
        <img class="w-full h-55 object-cover transition-transform duration-300 hover:scale-110" src="{{ asset($image) }}" alt="{{ $title }}">
    </div>
    <h2 class="pt-2 font-bold text-xl my-2">{{ $title }}</h2>
    <p class="line-clamp-3 text-gray-600 text-justify">{{ $description }}</p>

    <!-- Push button to bottom -->
    <div class="mt-auto pt-2">
        <button class="bg-orange-400 rounded-tr-full rounded-br-full p-2 px-3">Read More</button>
    </div>
</div>

