<div class="bg-white border border-b-gray-300 border-gray-300 hover:-translate-y-1 transform duration-300 p-2 max-w-md w-full h-full">
    <div class="bg-gray-200 flex flex-col border border-gray-300 p-4 h-full">
        <div>
            <img src="{{ asset($icon) }}" class="w-24 h-24 object-contain" />
        </div>
        <div class="flex flex-col py-2 flex-grow">
            <div class="text-xl font-bold">{{ $title }}</div>
            <div class="my-3 flex-grow">{{ $description }}</div>
            <button class="py-2 text-green-500 text-xl mt-auto text-start">Upcoming...</button>
        </div>
    </div>
</div>
