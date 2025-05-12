<div class="bg-white shadow rounded h-full flex flex-col">
    <div class="bg-white">
        <div class="flex m-5 gap-4">
            <img src="{{asset($image)}}" class="w-[30%]"/>
            <div class="gap-3">
                <h3 class="text-xl font-bold">{{$name}}</h3>
                <p class="text-md">{{$job}}</p>
            </div>
        </div>
        <p class="line-clamp-3 pb-5 px-5 text-justify">{{$description}}</p>
    </div>
</div>
