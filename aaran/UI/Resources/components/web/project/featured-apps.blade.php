<div class="bg-white border border-b-gray-300 border-gray-300 hover:-translate-y-1 transform duration-300 h-full p-2 max-w-md w-full mx-auto">
    <div onclick="window.location='{{ route('plan-details') }}'"
         class="bg-gray-200 border border-gray-300 p-4 h-full flex flex-col justify-between">
        <div>
            <img src="{{ asset($icon) }}" class="w-24 h-24 object-contain" />
        </div>
        <div class="flex flex-col py-2 flex-grow">
            <div class="text-xl font-bold">{{ $title }}</div>
            <div class="my-3 flex-grow">{{ $description }}</div>
            <button class="text-xl py-2 text-orange-400 my-4 mt-auto text-start">TRY NOW</button>
        </div>
    </div>
</div>
