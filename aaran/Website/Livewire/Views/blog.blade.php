<div>
    <x-Ui::web.home-new.items.banner label="Blog" desc=" We Design and develop Outstanding Digital products and digital -
                first Brands" padding="sm:px-[95px]" padding_mob="px-[40px]" />

    <x-Ui::alerts.notification />

    <div class="flex sm:flex-row flex-col-reverse justify-center font-roboto tracking-wider my-16 gap-6 scroll-smooth">

        <div class="sm:w-6/12 w-auto flex-col flex gap-y-16 border-r border-gray-200 sm:pr-6 sm:px-0 px-2">
            @forelse($list as $row)

                <div class="group flex-col flex border-b gap-y-5">
                    <div class="flex flex-row justify-between ">

                        <a href="{{route('posts.show',[$row->id])}}">

                            <div class="text-3xl font-semibold font-merri animate__animated wow animate__backInLeft " data-wow-duration="3s">{{\Illuminate\Support\Str::words($row->vname,16)}}
                            </div>
                        </a>
                        <!-- Drop down ---------------------------------------------------------------------------->

{{--                        @if(session()->get('tenant_id')!='')--}}
                            <x-Ui::dropdown.icon>
                                <div class="max-w-max  flex-col flex justify-start items-start space-y-3 text-xs">
                                    <button wire:click="edit({{$row->id}})" class="inline-flex items-center gap-x-2 px-2 py-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                        <span>Edit</span>
                                    </button>

                                    <button wire:click="confirmDelete({{$row->id}})" class="inline-flex items-center gap-x-2 px-2 py-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        <span>Delete</span>
                                    </button>

                                </div>
                            </x-Ui::dropdown.icon>
{{--                        @endif--}}
                    </div>

                    <div class="space-y-5 pb-16">
                        @if($row->image != 'no image')
                            <a href="{{route('posts.show',[$row->id])}}">
                                <div class="w-fill overflow-hidden shadow-md shadow-gray-400 rounded-sm">

                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::url('/images/'.$row->image) }}"
                                        alt="" class="w-full h-[30rem] object-cover transition duration-500 hover:scale-105 ease-out ">
                                </div>
                            </a>
                        @else
                            <x-Ui::image.empty-img />
                        @endif
                        <div class="text-xs text-gray-600 flex gap-x-5 justify-between font-lex">
                            <div class="flex gap-x-5">
                                <div class="inline-flex items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3 text-gray-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <span>{{ $row->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="inline-flex items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3 text-gray-600">
                                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                    </svg>
{{--                                    <span>POST BY : {{$row->user->name}}</span>--}}
                                </div>
                            </div>

                            <div class="inline-flex items-center space-x-5">
                                <div> {{$row->visibility==0?'Private':'Public'}}</div>
                                <div class="text-sm">|</div>
                                <div>#{{ $row->category->name ?? 'posts' }}</div>

                                <div class="text-sm">|</div>
                                <div>#{{ $row->tag->name ?? 'posts' }}</div>

                            </div>

                        </div>
                        <div class="indent-5 text-xs font-lex leading-loose">{{\Illuminate\Support\Str::words($row->body,30)}}</div>

                    </div>
                </div>
            @empty
                <x-Ui::image.empty_post />
            @endforelse
            <x-Ui::modal.delete />

            <div class="pt-5">{{ $list->links() }}</div>
        </div>

        <!--Search  --------------------------------------------------------------------------------------------------->

        <div class="sm:w-3/12 w-auto scroll-smooth sm:px-0 px-2 space-y-10">

            <div class=" w-full flex items-center justify-between">
                <div class="w-2/3 relative">
                    <label for="">

                        <span class="w-full">
                            <input type="text" placeholder="Search" wire:model.live="getListForm.searches" wire:keydown.escape="$set('getListForm.searches', '')" class="w-full h-11 border border-gray-200 rounded-sm focus:ring-0  bg-[#F9FAFB] text-gray-600 placeholder-gray-600 focus:border-pink-400 focus:placeholder-pink-600">
                        </span>

                        <span class="absolute top-0 right-0 w-14 h-11 bg-[#F31A49] inline-flex items-center justify-center rounded-r-sm">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-white">
                                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </label>
                </div>


                @if(session()->get('tenant_id')!='')
                    <div class="">
                        {{-- <button class="bg-pink-600 text-white text-md h-11 px-4 rounded-md " wire:click="create">New --}}

                        {{--                    </button>--}}
                        <div>
                            <x-Ui::button.new-x wire:click="create" />
                        </div>

                    </div>
                @endif
            </div>

            <!-- Form create  ----------------------------------------------------------------------------------------->

            <x-Ui::forms.create :id="$vid" :max-width="'xl'">
                <div class="flex flex-col gap-4">

                    <div class="inline-flex gap-3">
                        <input type="checkbox" wire:model="visibility">
                        <label for="">Public</label>
                    </div>

                    <x-Ui::input.floating wire:model="vname" label="Name" />
                    @error('vname')
                    <div class="text-xs text-red-500">
                        {{$message}}
                    </div>
                    @enderror

                    <x-Ui::input.textarea wire:model="body" label="Description" />
                    @error('body')
                    <div class="text-xs text-red-500">
                        {{$message}}
                    </div>
                    @enderror

                    <x-Ui::dropdown.wrapper label="Blog Category" type="blogcategoryTyped">
                        <div class="relative ">
                            <x-Ui::dropdown.input label="Blog Category" id="blog_category_name" wire:model.live="blog_category_name" wire:keydown.arrow-up="decrementBlogcategory" wire:keydown.arrow-down="incrementBlogcategory" wire:keydown.enter="enterBlogcategory" />
                            <x-Ui::dropdown.select>
                                @if($blogcategoryCollection)
                                    @forelse ($blogcategoryCollection as $i => $blogcategory)
                                        <x-Ui::dropdown.option highlight="{{$highlightBlogCategory === $i  }}" wire:click.prevent="setBlogcategory('{{$blogcategory->vname}}','{{$blogcategory->id}}')">
                                            {{ $blogcategory->vname }}
                                        </x-Ui::dropdown.option>
                                    @empty
                                        <button wire:click.prevent="blogcategorySave('{{$blog_category_name}}')" class="text-white bg-green-500 text-center w-full">
                                            create
                                        </button>
                                    @endforelse
                                @endif
                            </x-Ui::dropdown.select>
                        </div>
                    </x-Ui::dropdown.wrapper>

                    <x-Ui::dropdown.wrapper label="Blog Tag" type="blogtagTyped">
                        <div class="relative ">
                            <x-Ui::dropdown.input label="Blog Tag" id="blog_tag_name" wire:model.live="blog_tag_name" wire:keydown.arrow-up="decrementBlogtag" wire:keydown.arrow-down="incrementBlogtag" wire:keydown.enter="enterBlogtag" />
                            <x-Ui::dropdown.select>
                                @if($blogtagCollection)
                                    @forelse ($blogtagCollection as $i => $blogtag)
                                        <x-Ui::dropdown.option highlight="{{$highlightBlogCategory === $i  }}" wire:click.prevent="setBlogTag('{{$blogtag->vname}}','{{$blogtag->id}}')">
                                            {{ $blogtag->vname }}
                                        </x-Ui::dropdown.option>
                                    @empty
                                        <button wire:click.prevent="blogtagSave('{{$blog_tag_name}}')" class=" bg-blue-100 text-blue-600 text-center hover:font-bold w-full">
                                            create
                                        </button>
                                    @endforelse
                                @endif
                            </x-Ui::dropdown.select>
                        </div>
                    </x-Ui::dropdown.wrapper>

                    <!-- Image  ----------------------------------------------------------------------------------------------->

                    <div class="flex flex-col py-2">
                        <label for="bg_image" class="w-full text-zinc-500 tracking-wide pb-4 px-2">Image</label>
                        <div class="flex flex-wrap gap-2">
                            <div class="flex-shrink-0">
                                <div>
                                    @if($image)
                                        <div class=" flex-shrink-0 border-2 border-dashed border-gray-300 p-1 rounded-lg overflow-hidden">
                                            <img class="w-[156px] h-[89px] rounded-lg hover:brightness-110 hover:scale-105 duration-300 transition-all ease-out" src="{{ $image->temporaryUrl() }}" alt="{{$image?:''}}" />
                                        </div>
                                    @endif

                                    @if(!$image && isset($image))
                                        <img class="h-24 w-full" src="{{URL(\Illuminate\Support\Facades\Storage::url('images/'.$old_image))}}" alt="">
                                    @else
                                        <x-Ui::icons.icon :icon="'logo'" class="w-auto h-auto block " />
                                    @endif
                                </div>
                            </div>
                            <div class="relative">
                                <div>
                                    <label for="bg_image" class="text-gray-500 font-semibold text-base rounded flex flex-col items-center
                                   justify-center cursor-pointer border-2 border-gray-300 border-dashed p-2
                                   mx-auto font-[sans-serif]">
                                        <x-Ui::icons.icon icon="cloud-upload" class="w-8 h-auto block text-gray-400" />
                                        Upload Photo
                                        <input type="file" id='bg_image' wire:model="image" class="hidden" />
                                        <p class="text-xs font-light text-gray-400 mt-2">PNG and JPG are
                                            Allowed.</p>
                                    </label>
                                </div>

                                <div wire:loading wire:target="image" class="z-10 absolute top-6 left-12">
                                    <div class="w-14 h-14 rounded-full animate-spin
                                                        border-y-4 border-dashed border-green-500 border-t-transparent"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </x-Ui::forms.create>

            <div class="text-2xl font-semibold underline animate__animated wow bounceInRight" data-wow-duration="3s">Top
                Posts
            </div>

            <div class="flex-col flex gap-y-6">
                <div class="bg-white flex-col flex gap-y-5 group ">
                    @foreach($topPost as $row)
                        <div class="w-full h-auto flex gap-x-2 hover:bg-slate-100 group animate__animated wow animate__backInRight " data-wow-duration="3s">
                            <div class="w-2/6 overflow-hidden">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url('/images/' . ($row->image ?? 'default.png')) }}"
                                     alt="no image" class="w-full h-20 object-cover transition ease-in-out duration-300 hover:scale-105">
                            </div>

                            <div class="w-4/6 flex-col flex py-1 font-lex">
                                <div class="h-1/4 inline-flex items-center gap-x-2">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-2">
                                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                    </svg>
                                </span>
{{--                                    <span class="text-xs text-gray-600">By {{$row->user->name}}</span>--}}
                                </div>
                                <div class="3/4 flex-col flex justify-start items-start ">
                                    <div class="text-sm font-semibold font-merri">
{{--                                        {{\Illuminate\Support\Str::words($row->vname, 5)}}--}}
                                        {{ isset($row['vname']) ? \Illuminate\Support\Str::words($row['vname'], 5) : '' }}

                                    </div>

                                    <div class="text-xs text-gray-600">
{{--                                        {{\Illuminate\Support\Str::words($row->body, 9)}}--}}
                                        {{ isset($row['body']) ? \Illuminate\Support\Str::words($row['body'], 5) : '' }}

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="w-full border"></div>
            <!-- Blog Category ---------------------------------------------------------------------------------------->

            <div class="text-2xl font-semibold underline scroll-smooth animate__animated wow bounceInRight" data-wow-duration="3s">Category

            </div>

            <div class="flex-col flex justify-between w-full overflow-y-auto h-72">

                @if(!is_null($BlogCategories))
                @foreach($BlogCategories as $blogcategory)

                    <button wire:click="getCategory_id({{$blogcategory->id}})" class="h-12 w-3/4 inline-flex items-center gap-x-4 py-2 my-3 bg-red-50 text-red-600 px-4 group hover:bg-red-600 rounded-md mr-2 transition-all ease-linear duration-300
                            animate__animated wow animate__backInRight" data-wow-duration="3s">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-red-600 group-hover:text-white">
                            <path fill-rule="evenodd" d="M1.5 7.125c0-1.036.84-1.875 1.875-1.875h6c1.036 0 1.875.84 1.875 1.875v3.75c0 1.036-.84 1.875-1.875 1.875h-6A1.875 1.875 0 0 1 1.5 10.875v-3.75Zm12 1.5c0-1.036.84-1.875 1.875-1.875h5.25c1.035 0 1.875.84 1.875 1.875v8.25c0 1.035-.84 1.875-1.875 1.875h-5.25a1.875 1.875 0 0 1-1.875-1.875v-8.25ZM3 16.125c0-1.036.84-1.875 1.875-1.875h5.25c1.036 0 1.875.84 1.875 1.875v2.25c0 1.035-.84 1.875-1.875 1.875h-5.25A1.875 1.875 0 0 1 3 18.375v-2.25Z" clip-rule="evenodd" />
                        </svg>

                        <span class="group-hover:text-white">{{$blogcategory->vname}}</span>
                    </button>
                @endforeach
                @endif

            </div>

            <div class="w-full border"></div>

            <!-- Tag Filter ------------------------------------------------------------------------------------------->

            <div class="flex flex-row flex-wrap w-full gap-5 my-8 p-0.5 group">
                @if(session()->get('tenant_id')!='')
                    @if($tagfilter)
                        @foreach($tagfilter as $index => $i)
                            <div class="inline-flex items-center bg-blue-50 border border-gray-200 rounded-md px-2 gap-3 justify-between hover:bg-blue-100
                            hover:text-blue-800 transition-all ease-linear duration-300 hover:border-blue-600">
                                <span> {{\Aaran\Blog\Models\BlogTag::find($i)->vname}}</span>

                                <span>
                        <button wire:click="removeFilter({{$index}})" class="flex items-center justify-end">
                            <x-Ui::icons.icon :icon="'x-mark'" class="w-4 h-4" />
                        </button>
                    </span>

                            </div>
                        @endforeach
                        <button wire:click="clearFilter()" class="max-w-max px-2 py-1 border border-gray-200 bg-blue-50 rounded-md text-xs hover:text-blue-800 hover:bg-blue-100 hover:border hover:border-blue-600">
                            Clear All
                        </button>
                    @endif
                @endif
            </div>

            <!-- Blog Tag --------------------------------------------------------------------------------------------->

            <div class="text-2xl font-semibold my-8 underline">Tags</div>

            <div class="text-sm h-64 overflow-y-auto space-y-3">
                @if($tags)
                    @foreach($tags as $tag)
                        <button wire:click="getFilter({{$tag->id}})" class="group px-4 py-2 border-s-2 border-gray-200 max-w-max h-8 text-center bg-red-50 hover:bg-red-600 hover:text-white duration-300 transition-all ease-linear inline-flex items-center
                                 gap-x-3 rounded-md mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-red-600 group-hover:text-white">
                                <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs text-red-600 group-hover:text-white">{{$tag->vname}} </span>
                        </button>
                    @endforeach
                @endif
            </div>


        </div>
    </div>

    <x-Ui::web.home-new.footer />
</div>
