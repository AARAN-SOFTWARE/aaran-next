<div>
    <x-Ui::lookup.modal-new>

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


    </x-Ui::lookup.modal-new>
</div>
