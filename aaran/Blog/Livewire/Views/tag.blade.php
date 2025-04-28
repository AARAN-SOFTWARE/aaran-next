<div>
    <x-slot name="header">Blog Tag</x-slot>

    <x-Ui::forms.m-panel>
        <x-Ui::alerts.notification />


        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <x-Ui::table.caption :caption="'Blog Tag'">
            {{$list->count()}}
        </x-Ui::caption>

         <x-Ui::table.form>
            <x-slot:table_header name="table_header">

                <x-Ui::table.header-serial width="20%"/>

                <x-Ui::table.header-text wire:click.prevent="sortBy('id')" sortIcon="{{$sortAsc}}">
                    Name
                </x-Ui::table.header-text>

                <x-Ui::table.header-text wire:click.prevent="sortBy('blog_category_id')" sortIcon=false>Blog
                    Category
                </x-Ui::table.header-text>
                <x-Ui::table.header-action/>

            </x-slot:table_header>

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)

                   <x-Ui::table.row>
                        <x-Ui::table.cell-text>{{$index+1}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->vname}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>
{{--                            {{\Aaran\Blog\Models\BlogTag::common($row->blogcategory_id)}}--}}
                            {{ optional($row->blogCategory)->vname ?? '-' }}
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-action id="{{$row->id}}"/>
                    </x-Ui::table.row>

                @endforeach
            </x-slot:table_body>

        </x-Ui::table.form>
        <!-- Delete Modal --------------------------------------------------------------------------------------------->
        <x-Ui::modal.confirm-delete/>

        <x-Ui::forms.create :id="$vid">

            <div class="flex flex-col  gap-3">

                <div>
                    <x-Ui::input.floating wire:model="vname" label="Tag Name"/>
                    <x-Ui::input.error-text wire:model="vname" />
                </div>


                <x-Ui::dropdown.wrapper label="Blog Category" type="blogcategoryTyped">
                    <div class="relative ">
                        <x-Ui::dropdown.input label="Blog Category" id="blog_category_name"
                                          wire:model.live="blog_category_name"
                                          wire:keydown.arrow-up="decrementBlogcategory"
                                          wire:keydown.arrow-down="incrementBlogcategory"
                                          wire:keydown.enter="enterBlogcategory"/>
                        <x-Ui::dropdown.select>
                            @if($blogcategoryCollection)
                                @forelse ($blogcategoryCollection as $i => $blogcategory)
                                    <x-Ui::dropdown.option highlight="{{$highlightBlogCategory === $i  }}"
                                                       wire:click.prevent="setBlogcategory('{{$blogcategory->vname}}','{{$blogcategory->id}}')">
                                        {{ $blogcategory->vname }}
                                    </x-Ui::dropdown.option>
                                @empty
                                    <button
                                        wire:click.prevent="blogcategorySave('{{$blog_category_name}}')"
                                        class="text-white bg-green-500 text-center w-full">
                                        create
                                    </button>
                                @endforelse
                            @endif
                        </x-Ui::dropdown.select>
                    </div>
                    <div>
                        <x-Ui::input.error-text wire:model="blog_category_id" />
                    </div>
                </x-Ui::dropdown.wrapper>


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
        </x-Ui::forms.create>
     </x-Ui::forms.m-panel>
</div>
