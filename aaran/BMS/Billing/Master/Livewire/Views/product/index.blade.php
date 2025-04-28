<div>
    <x-slot name="header">Products</x-slot>

    <x-Ui::forms.m-panel>
        <x-Ui::alerts.notification/>

        <!-- Top Controls --------------------------------------------------------------------------------------------->

        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <x-Ui::table.caption :caption="'Products'">
            {{$list->count()}}
        </x-Ui::table.caption>

        <!-- Table Header --------------------------------------------------------------------------------------------->

        <x-Ui::table.form>
            <x-slot:table_header name="table_header" class="bg-green-100">

                <x-Ui::table.header-serial width="20%"/>

                <x-Ui::table.header-text wire:click.prevent="sortBy('vname')" sortIcon="{{$sortAsc}}"
                >Product
                </x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">Product&nbsp;Type</x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">HSN&nbsp;Code</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Gst&nbsp;Percent</x-Ui::table.header-text>
                <x-Ui::table.header-text sortIcon="none">Opening&nbsp;qty</x-Ui::table.header-text>

                <x-Ui::table.header-action/>

            </x-slot:table_header>

            <!-- Table Body ------------------------------------------------------------------------------------------->

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)

                    <x-Ui::table.row>
                        <x-Ui::table.cell-text>{{$index+1}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->vname}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>
                            {{ $row->product_type_id ? \Aaran\Assets\Enums\ProductType::tryFrom($row->product_type_id)->getName():''}}
                        </x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->hsncode->vname}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->gst_percent->vname}}%</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->initial_quantity+0}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-action id="{{$row->id}}"/>
                    </x-Ui::table.row>

                @endforeach

            </x-slot:table_body>
        </x-Ui::table.form>

        <!-- Delete Modal --------------------------------------------------------------------------------------------->
        <x-Ui::modal.confirm-delete/>
        <div class="">{{ $list->links() }}</div>

        <!-- Create  -------------------------------------------------------------------------------------------------->

        <x-Ui::forms.create :id="$vid">

            <div class="flex flex-col gap-3">

                <!-- Product ------------------------------------------------------------------------------------------>

                <div>
                    <x-Ui::input.floating wire:model.live="vname" label="Product Name"/>
                    <x-Ui::input.error-text wire:model="vname"/>
                </div>

                <x-Ui::dropdown.wrapper label="Product Type" type="productTypeTyped">

                    <div class="relative">
                        <x-Ui::dropdown.input label="Product Type" id="product_type_name"
                                              wire:model.live="product_type_name"
                                              wire:keydown.arrow-up="decrementProductType"
                                              wire:keydown.arrow-down="incrementProductType"
                                              wire:keydown.enter="enterProductType"/>

                        <x-Ui::dropdown.select>
                            @if($productTypeCollection)
                                @forelse (\Aaran\Assets\Enums\ProductType::cases() as $i => $productType)

                                    <x-Ui::dropdown.option highlight="{{$highlightProductType === $i  }}"
                                                           wire:click.prevent="setProductType('{{$productType->name}}','{{$productType->value}}')">
                                        {{ $productType->getName() }}
                                    </x-Ui::dropdown.option>

                                @empty
                                    <x-Ui::dropdown.new wire:click.prevent="productTypeSave('{{$product_type_name}}')"
                                                        label="Product"/>
                                @endforelse
                            @endif

                        </x-Ui::dropdown.select>
                    </div>
                </x-Ui::dropdown.wrapper>


                <!-- HSN Code ----------------------------------------------------------------------------------------->

                <x-Ui::dropdown.wrapper label="HSN Code" type="hsncodeTyped">

                    <div class="relative">

                        <x-Ui::dropdown.input label="HSN Code" id="hsncode_name"
                                              wire:model.live="hsncode_name"
                                              wire:keydown.arrow-up="decrementHsncode"
                                              wire:keydown.arrow-down="incrementHsncode"
                                              wire:keydown.enter="enterHsncode"/>

                        <x-Ui::dropdown.select>
                            @if($hsncodeCollection)

                                @forelse ($hsncodeCollection as $i => $hsncode)
                                    <x-Ui::dropdown.option highlight="{{$highlightHsncode === $i  }}"
                                                           wire:click.prevent="setHsncode('{{$hsncode->vname}}','{{$hsncode->id}}')">
                                        {{ $hsncode->vname }}
                                    </x-Ui::dropdown.option>

                                @empty
                                    <x-Ui::dropdown.new wire:click.prevent="hsncodeSave('{{$hsncode_name}}')"
                                                        label="HSN Code"/>
                                @endforelse
                            @endif

                        </x-Ui::dropdown.select>
                    </div>
                    <x-Ui::input.error-text wire:model="hsncode_name"/>
                </x-Ui::dropdown.wrapper>

                <!-- Unit Type ---------------------------------------------------------------------------------------->

                <x-Ui::dropdown.wrapper label="Unit" type="unitTyped">
                    <div class="relative ">
                        <x-Ui::dropdown.input label="Unit" id="unit_name"
                                              wire:model.live="unit_name"
                                              wire:keydown.arrow-up="decrementUnit"
                                              wire:keydown.arrow-down="incrementUnit"
                                              wire:keydown.enter="enterUnit"/>
                        <x-Ui::dropdown.select>
                            @if($unitCollection)
                                @forelse ($unitCollection as $i => $unit)
                                    <x-Ui::dropdown.option highlight="{{$highlightUnit === $i  }}"
                                                           wire:click.prevent="setUnit('{{$unit->vname}}','{{$unit->id}}')">
                                        {{ $unit->vname }}
                                    </x-Ui::dropdown.option>
                                @empty
                                    <x-Ui::dropdown.new wire:click.prevent="unitSave('{{$unit_name}}')" label="Units"/>
                                @endforelse
                            @endif
                        </x-Ui::dropdown.select>
                    </div>
                    <x-Ui::input.error-text wire:model="unit_name"/>
                </x-Ui::dropdown.wrapper>

                <!-- GST Percent -------------------------------------------------------------------------------------->

                <x-Ui::dropdown.wrapper label="GST Percent" type="gstPercentTyped">
                    <div class="relative ">
                        <x-Ui::dropdown.input label="GST Percent" id="gst_percent_name"
                                              wire:model.live="gst_percent_name"
                                              wire:keydown.arrow-up="decrementGstPercent"
                                              wire:keydown.arrow-down="incrementGstPercent"
                                              wire:keydown.enter="enterGstPercent"/>
                        <x-Ui::dropdown.select>
                            @if($gstPercentCollection)
                                @forelse ($gstPercentCollection as $i => $gstPercent)
                                    <x-Ui::dropdown.option highlight="{{$highlightGstPercent === $i}}"
                                                           wire:click.prevent="setGstPercent('{{$gstPercent->vname}}','{{$gstPercent->id}}')">
                                        {{ $gstPercent->vname }}
                                    </x-Ui::dropdown.option>
                                @empty
                                    <x-Ui::dropdown.new wire:click.prevent="gstPercentSave('{{$gst_percent_name}}')"
                                                        label="GST Percent"/>
                                @endforelse
                            @endif

                        </x-Ui::dropdown.select>
                    </div>
                    <x-Ui::input.error-text wire:model="gst_percent_name"/>
                </x-Ui::dropdown.wrapper>

                <x-Ui::input.floating wire:model="quantity" label="Opening Quantity"/>
                <x-Ui::input.floating wire:model="price" label="Opening Price"/>
            </div>

        </x-Ui::forms.create>

        <!-- Actions ------------------------------------------------------------------------------------------->

    </x-Ui::forms.m-panel>
    {{--    <div class="px-10  py-16 space-y-4">--}}
    {{--        @if(!$log->isEmpty())--}}
    {{--            <div class="text-xs text-orange-600  font-merri underline underline-offset-4">Activity</div>--}}
    {{--        @endif--}}
    {{--        @foreach($log as $row)--}}
    {{--            <div class="px-6">--}}
    {{--                <div class="relative ">--}}
    {{--                    <div class=" border-l-[3px] border-dotted px-8 text-[10px]  tracking-wider py-3">--}}
    {{--                        <div class="flex gap-x-5 ">--}}
    {{--                            <div class="inline-flex text-gray-500 items-center font-sans font-semibold">--}}
    {{--                                <span>Invoice No:</span> <span>{{$row->vname}}</span></div>--}}
    {{--                            <div class="inline-flex  items-center space-x-1 font-merri"><span--}}
    {{--                                    class="text-blue-600">@</span><span class="text-gray-500">{{$row->user->name}}</span>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div--}}
    {{--                            class="text-gray-400 text-[8px] font-semibold">{{date('M d, Y', strtotime($row->created_at))}}</div>--}}
    {{--                        <div class="pb-2 font-lex leading-5 py-2 text-justify">{!! $row->description !!}</div>--}}
    {{--                    </div>--}}
    {{--                    <div class="absolute top-0 -left-1 h-2.5 w-2.5  rounded-full bg-teal-600 "></div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        @endforeach--}}
    {{--    </div>--}}
</div>
