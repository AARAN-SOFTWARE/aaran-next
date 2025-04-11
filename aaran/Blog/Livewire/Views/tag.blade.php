<div>
    <x-slot name="header">Blog Tag</x-slot>

    <x-aaran-ui::forms.m-panel>
        <x-aaran-ui::alerts.notification />


        <x-aaran-ui::forms.top-controls :show-filters="$showFilters"/>

        <x-aaran-ui::table.caption :caption="'Blog Tag'">
            {{$list->count()}}
        </x-aaran-ui::caption>

         <x-aaran-ui::table.form>
            <x-slot:table_header name="table_header">

                <x-aaran-ui::table.header-serial width="20%"/>

                <x-aaran-ui::table.header-text wire:click.prevent="sortBy('vname')">
                    vname
                </x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text wire:click.prevent="sortBy('blog_category_id')" sortIcon="{{$getListForm->sortAsc}}">Blog
                    Category
                </x-aaran-ui::table.header-text>
                <x-aaran-ui::table.header-action/>

            </x-slot:table_header>

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)

                   <x-aaran-ui::table.row>
                        <x-aaran-ui::table.cell-text>{{$index+1}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text>{{$row->vname}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text>
{{--                            {{\Aaran\Blog\Models\BlogTag::common($row->blogcategory_id)}}--}}
                            {{ optional($row->blogCategory)->vname ?? '-' }}

                        </x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-action id="{{$row->id}}"/>
                    </x-aaran-ui::table.row>

                @endforeach
            </x-slot:table_body>

        </x-aaran-ui::table.form>
        <x-aaran-ui::modal.delete/>

        <x-aaran-ui::forms.create :id="$common->vid">

            <div class="flex flex-col  gap-3">

                <x-aaran-ui::input.floating wire:model="common.vname" label="Tag Name"/>

                <x-aaran-ui::dropdown.wrapper label="Blog Category" type="blogcategoryTyped">
                    <div class="relative ">
                        <x-aaran-ui::dropdown.input label="Blog Category" id="blog_category_name"
                                          wire:model.live="blog_category_name"
                                          wire:keydown.arrow-up="decrementBlogcategory"
                                          wire:keydown.arrow-down="incrementBlogcategory"
                                          wire:keydown.enter="enterBlogcategory"/>
                        <x-aaran-ui::dropdown.select>
                            @if($blogcategoryCollection)
                                @forelse ($blogcategoryCollection as $i => $blogcategory)
                                    <x-aaran-ui::dropdown.option highlight="{{$highlightBlogCategory === $i  }}"
                                                       wire:click.prevent="setBlogcategory('{{$blogcategory->vname}}','{{$blogcategory->id}}')">
                                        {{ $blogcategory->vname }}
                                    </x-aaran-ui::dropdown.option>
                                @empty
                                    <button
                                        wire:click.prevent="blogcategorySave('{{$blog_category_name}}')"
                                        class="text-white bg-green-500 text-center w-full">
                                        create
                                    </button>
                                @endforelse
                            @endif
                        </x-aaran-ui::dropdown.select>
                    </div>
                </x-aaran-ui::dropdown.wrapper>

                {{--                <div class="flex flex-row py-3 gap-3">--}}
                {{--                    <div class="xl:flex w-full gap-2">--}}
                {{--                        <label for="blogcategory_name"--}}
                {{--                               class="w-[10rem] text-zinc-500 tracking-wide py-2">Blog Category</label>--}}
                {{--                        <div x-data="{isTyped: @entangle('blogcategoryTyped')}" @click.away="isTyped = false"--}}
                {{--                             class="w-full relative">--}}
                {{--                            <div>--}}
                {{--                                <input--}}
                {{--                                    id="blogcategory_name"--}}
                {{--                                    type="search"--}}
                {{--                                    wire:model.live="blogcategory_name"--}}
                {{--                                    autocomplete="off"--}}
                {{--                                    placeholder="Blog Category Name.."--}}
                {{--                                    @focus="isTyped = true"--}}
                {{--                                    @keydown.escape.window="isTyped = false"--}}
                {{--                                    @keydown.tab.window="isTyped = false"--}}
                {{--                                    @keydown.enter.prevent="isTyped = false"--}}

                {{--                                    class="block w-full rounded-lg"--}}
                {{--                                />--}}

                {{--                                <!-- HSN Code Dropdown -->--}}
                {{--                                <div x-show="isTyped"--}}
                {{--                                     x-transition:leave="transition ease-in duration-100"--}}
                {{--                                     x-transition:leave-start="opacity-100"--}}
                {{--                                     x-transition:leave-end="opacity-0"--}}
                {{--                                     x-cloak--}}
                {{--                                >--}}
                {{--                                    <div class="absolute z-20 w-full mt-2">--}}
                {{--                                        <div class="block py-1 shadow-md w-full rounded-lg border-transparent flex-1 appearance-none border--}}
                {{--                             bg-white text-gray-800 ring-1 ring-purple-600">--}}
                {{--                                            <ul class="overflow-y-scroll h-20">--}}
                {{--                                                @if($blogcategoryCollection)--}}
                {{--                                                    @forelse ($blogcategoryCollection as $i => $blogcategory)--}}
                {{--                                                        <li class="cursor-pointer px-3 py-1 hover:font-bold hover:bg-yellow-100 border-b border-gray-300 h-8--}}
                {{--                                            {{ $highlightBlogCategory === $i ? 'bg-yellow-100' : '' }}"--}}
                {{--                                                            wire:click.prevent="setBlogcategory('{{$blogcategory->vname}}','{{$blogcategory->id}}')"--}}
                {{--                                                            x-on:click="isTyped = false">--}}
                {{--                                                            {{ $blogcategory->vname }}--}}
                {{--                                                        </li>--}}
                {{--                                                    @empty--}}
                {{--                                                        <button--}}
                {{--                                                            wire:click.prevent="blogcategorySave('{{$blogcategory_name}}')"--}}
                {{--                                                            class="text-white bg-green-500 text-center w-full">--}}
                {{--                                                            create--}}
                {{--                                                        </button>--}}
                {{--                                                    @endforelse--}}
                {{--                                                @endif--}}
                {{--                                            </ul>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

            </div>
        </x-aaran-ui::forms.create>
     </x-aaran-ui::forms.m-panel>
</div>
