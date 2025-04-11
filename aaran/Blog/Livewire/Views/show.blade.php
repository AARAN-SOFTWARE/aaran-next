<div>
    <x-slot name="header">Show</x-slot>
    <div class="bg-gray-100 h-14 flex items-center">
        <div class="w-9/12 mx-auto text-gray-700 text-lg font-roboto tracking-wider">
            Blog
        </div>
    </div>
    <!-- Content --------------------------------------------------------------------------------------->
    <div class="flex justify-center font-roboto tracking-wider">
        <div class="w-7/12 gap-y-5 border-r border-gray-200 pr-16">

            <div class="w-full h-[45rem] flex flex-col justify-center items-center gap-7">

                <div class="w-full flex flex-col gap-1.5">
                    <div class="text-2xl capitalize">
                        {{$posts->vname}}
                    </div>
                    <div class="text-gray-500 uppercase">
                        <span>news,</span>
                        <span>category</span>
                    </div>
                </div>

                <img
                    src="{{URL(\Illuminate\Support\Facades\Storage::url('/images/'.$posts->image))}}"
                    alt="{{$posts->image}}" class="h-[25rem] w-full"/>

                <div class="text-gray-700">
                    {{$posts->body}}
                </div>
            </div>

            <div class="text-gray-500 inline-flex">
                <time>{{ $posts->created_at->diffForHumans() }} /</time>
                <span>&nbsp;By,{{ $posts->user->name }}</span>
            </div>
        </div>

        <div class="w-2/12 pl-16 flex flex-col justify-center gap-y-7">

            <div class="w-full">
                <x-aaran-ui::icons.search-new/>
            </div>


            <div class="inline-flex gap-3">
                <img src="../../../../images/blog/demo.jpg" alt="" class="w-10 h-10">

                <div>
                    <div class="uppercase">sadasd</div>
                    <div class="text-sm">JUN.14,2024 - 3.25am</div>
                </div>
            </div>

            <div class="inline-flex gap-3">
                <img src="../../../../images/blog/demo.jpg" alt="" class="w-10 h-10">

                <div>
                    <div class="uppercase">sadasd</div>
                    <div class="text-sm">JUN.14,2024 - 3.25am</div>
                </div>
            </div>

            <div class="inline-flex gap-3">
                <img src="../../../../images/blog/demo.jpg" alt="" class="w-10 h-10">

                <div>
                    <div class="uppercase">sadasd</div>
                    <div class="text-sm">JUN.14,2024 - 3.25am</div>
                </div>
            </div>

            <div class="inline-flex gap-3">
                <img src="../../../../images/blog/demo.jpg" alt="" class="w-10 h-10">

                <div>
                    <div class="uppercase">sadasd</div>
                    <div class="text-sm">JUN.14,2024 - 3.25am</div>
                </div>
            </div>

            <div class="flex flex-col gap-y-3 my-2.5">
                <div class="">
                    Category
                </div>

                <div class="flex flex-col gap-y-1.5 text-gray-500">
                    <div> News</div>
                    <div> Personal</div>
                    <div>Uncategorized</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comment Show --------------------------------------------------------------------------------------->

    <div class="w-9/12 flex flex-col mx-auto justify-center my-12 gap-y-5">

        <div class="w-[800px] ">

            <div class="text-lg tracking-wider flex-row flex gap-2">
                <span>Post Comments</span>

                <div class="inline-flex gap-1.5">
                    <x-aaran-ui::icons.icon :icon="'annotation'"
                                  class="w-6 h-5"/>
                    <span class="text-md">({{$commentsCount}})</span>
                </div>
            </div>

            @foreach($list as $row)

                <div class="h-32 gap-y-3 border-b shadow-md border my-3 flex flex-col justify-center p-2 group relative">
                    <div class="flex flex-row">
                        <img src="../../../../images/wp1.webp" alt="" class="w-10 h-10 rounded-full">

                        <div class="flex flex-col mx-3">
                            <span class="text-sm capitalize">{{$row->user->name}}</span>
                            <span class="text-xs text-gray-500">{{$row->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="w-full">
                        {{$row->body}}
                    </div>


                    <div class="flex">
                        <x-aaran-ui::icons.icon :icon="'pencil'" wire:click="editComment({{ $row->id }})"
                                      class="text-gray-400 h-5 hover:cursor-pointer hover:text-black px-0.5 py-0.5 hover:rounded-sm inline-flex invisible group-hover:visible "/>
                        <x-aaran-ui::icons.icon :icon="'trash'" wire:click="getDelete({{ $row->id }})"
                                      class="text-gray-400 h-5 hover:cursor-pointer hover:text-black px-0.5 py-0.5 hover:rounded-sm inline-flex invisible group-hover:visible"/>

                    </div>
                </div>
                <x-aaran-ui::modal.delete/>
            @endforeach
        </div>

        <!-- Comment --------------------------------------------------------------------------------------->

        <div class="h-80 px-7 w-[700px] rounded-[12px] p-4 shadow-md border">
            <p class="text-xl font-semibold text-blue-900 cursor-pointer transition-all hover:text-black">
                Add Comment
            </p>
            <textarea
                class="h-40 px-3 text-sm py-1 mt-5 outline-none border-gray-300 w-full resize-none border rounded-lg placeholder:text-sm"
                wire:model="body"
                placeholder="Add your comments here"></textarea>

            <div class="flex justify-between mt-2">
                <p class="text-sm text-blue-900 ">Enter atleast 15 characters</p>
                <button wire:click="save"
                        class="h-12 w-[150px] bg-blue-400 text-sm text-white rounded-lg transition-all cursor-pointer hover:bg-blue-600">
                    Submit comment
                </button>
            </div>
        </div>

    </div>

</div>
