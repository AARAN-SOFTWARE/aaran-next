<div>
    <x-slot name="header">Sales</x-slot>
    {{--    <x-Ui::forms.m-panel>--}}
    <x-Ui::alerts.notification/>

    <div class="pt-10 min-h-[40rem]">
        <div class="space-y-5">
            <div class="max-w-6xl mx-auto">
                <x-Ui::tabs.tab-panel>
                    <x-slot name="tabs">
                        <x-Ui::tabs.tab>Details</x-Ui::tabs.tab>
                        <x-Ui::tabs.tab>Address</x-Ui::tabs.tab>
                        <x-Ui::tabs.tab>E-way Bill Details</x-Ui::tabs.tab>
                        <x-Ui::tabs.tab>Destination</x-Ui::tabs.tab>
                        <x-Ui::tabs.tab>Additional Charges</x-Ui::tabs.tab>
                        <x-Ui::tabs.tab>Terms</x-Ui::tabs.tab>
                    </x-slot>
                    <x-slot name="content">
                        <x-Ui::tabs.content>

                            <div class="space-y-5 py-3">
                                <div class="w-full flex gap-5 ">

                                    <div class="w-full space-y-3">

                                        <div>

                                            <x-Ui::dropdown.wrapper label="Party Name" type="contactTyped">
                                                <div class="relative ">
                                                    <x-Ui::dropdown.input label="Party Name" id="contact_name"
                                                                          wire:model.live.debounce="contact_name"
                                                                          wire:keydown.arrow-up="decrementContact"
                                                                          wire:keydown.arrow-down="incrementContact"
                                                                          wire:keydown.enter="enterContact"/>
                                                    @error('contact_id')
                                                    <span
                                                        class="text-red-500">{{'The Party Name is Required.'}}</span>
                                                    @enderror
                                                    <x-Ui::dropdown.select>
                                                        @if($contactCollection)
                                                            @forelse ($contactCollection as $i => $contact)
                                                                <x-Ui::dropdown.option
                                                                    highlight="{{$highlightContact === $i  }}"
                                                                    wire:click.prevent="setContact('{{$contact->vname}}','{{$contact->id}}')">
                                                                    {{ $contact->vname }}
                                                                </x-Ui::dropdown.option>
                                                            @empty
                                                                @livewire('master::contact-modal',[$contact_name])
                                                            @endforelse
                                                        @endif
                                                    </x-Ui::dropdown.select>
                                                </div>
                                            </x-Ui::dropdown.wrapper>

                                            <x-Ui::input.error-text wire:model="contact_name"/>

                                        </div>

                                        <div>

                                            @if(\Aaran\Assets\Features\SaleEntry::hasOrder())

                                                <x-Ui::dropdown.wrapper label="Order NO" type="orderTyped">
                                                    <div class="relative ">
                                                        <x-Ui::dropdown.input label="Order NO" id="order_name"
                                                                              x-ref="order_name"
                                                                              wire:model.live="order_name"
                                                                              wire:keydown.arrow-up="decrementOrder"
                                                                              wire:keydown.arrow-down="incrementOrder"
                                                                              wire:keydown.enter="enterOrder"/>

                                                        <x-Ui::input.error-text wire:model="order_name"/>

                                                        <x-Ui::dropdown.select>
                                                            @if($orderCollection)
                                                                @forelse ($orderCollection as $i => $order)
                                                                    <x-Ui::dropdown.option
                                                                        highlight="{{$highlightOrder === $i  }}"
                                                                        wire:click.prevent="setOrder('{{$order->vname}}','{{$order->id}}')">
                                                                        {{ $order->vname }}
                                                                    </x-Ui::dropdown.option>
                                                                @empty
                                                                    @livewire('master::order-modal',[$order_name])
                                                                @endforelse
                                                            @endif
                                                        </x-Ui::dropdown.select>
                                                    </div>
                                                </x-Ui::dropdown.wrapper>

                                            @endif
                                        </div>

                                        <div>

                                            @if(\Aaran\Assets\Features\SaleEntry::hasStyle())

                                                <x-Ui::dropdown.wrapper label="Style" type="style_name">
                                                    <div class="relative ">

                                                        <x-Ui::dropdown.input label="Style" id="style_name"
                                                                              wire:model.live="style_name"
                                                                              wire:keydown.arrow-up="decrementStyle"
                                                                              wire:keydown.arrow-down="incrementStyle"
                                                                              wire:keydown.enter="enterStyle"/>

                                                        <x-Ui::input.error-text wire:model="style_name"/>

                                                        <x-Ui::dropdown.select>

                                                            @if($styleCollection)
                                                                @forelse ($styleCollection as $i => $style)
                                                                    <x-Ui::dropdown.option
                                                                        highlight="{{$highlightStyle === $i  }}"
                                                                        wire:click.prevent="setStyle('{{$style->vname}}','{{$style->id}}')">
                                                                        {{ $style->vname }}
                                                                    </x-Ui::dropdown.option>
                                                                @empty
                                                                    @livewire('master::style-modal',[$style_name])
                                                                @endforelse
                                                            @endif
                                                        </x-Ui::dropdown.select>

                                                    </div>
                                                </x-Ui::dropdown.wrapper>

                                            @endif
                                        </div>
                                    </div>

                                    <div class="w-full space-y-3 ">
                                        <div class="h-16 ">
                                            <x-Ui::input.floating wire:model="invoice_no" label="Invoice No"/>
                                            @error('invoice_no')
                                            <span class="text-red-500">{{'Invoice No is Required.'}}</span>
                                            @enderror
                                        </div>
                                        <div class="h-16 ">
                                            <x-Ui::input.model-date wire:model="invoice_date" label="Invoice Date"/>
                                            @error('invoice_date')
                                            <span class="text-red-500">{{'Invoice Date is Required.'}}</span>
                                            @enderror
                                        </div>
                                        <div class=" ">
                                            @if(\Aaran\Assets\Features\SaleEntry::hasJob_no())
                                                <x-Ui::input.floating wire:model="job_no" label="Job No"/>
                                            @endif
                                        </div>
                                        <div class="">
                                            @if(\Aaran\Assets\Features\SaleEntry::hasDespatch())
                                                <x-Ui::dropdown.wrapper label="Despatch No" type="despatchTyped">
                                                    <div class="relative ">
                                                        <x-Ui::dropdown.input
                                                            label="Despatch No"
                                                            id="despatch_name"
                                                            wire:model.live="despatch_name"
                                                            wire:keydown.arrow-up="decrementDespatch"
                                                            wire:keydown.arrow-down="incrementDespatch"
                                                            wire:keydown.enter="enterDespatch"/>

                                                        @error('despatch_id')
                                                        <span class="text-red-500">{{'Despatch No is Required.'}}</span>
                                                        @enderror

                                                        <x-Ui::dropdown.select>
                                                            @if($despatchCollection)
                                                                @forelse ($despatchCollection as $i => $despatch)
                                                                    <x-Ui::dropdown.option
                                                                        highlight="{{$highlightDespatch === $i  }}"
                                                                        wire:click.prevent="setDespatch('{{$despatch->vname}}','{{$despatch->id}}')">
                                                                        {{ $despatch->vname }}
                                                                    </x-Ui::dropdown.option>
                                                                @empty
                                                                    <button
                                                                        wire:click.prevent="despatchSave('{{$despatch_name}}')"
                                                                        class="text-white bg-green-500 text-center w-full">
                                                                        create
                                                                    </button>
                                                                @endforelse
                                                            @endif
                                                        </x-Ui::dropdown.select>
                                                    </div>
                                                </x-Ui::dropdown.wrapper>
                                            @endif
                                        </div>
                                        <div class="h-16 ">
                                            <x-Ui::input.model-select wire:model="sales_type" :label="'Sales Type'">
                                                <option class="text-gray-400"> choose ..</option>
                                                <option value="1">CGST-SGST</option>
                                                <option value="2">IGST</option>
                                            </x-Ui::input.model-select>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-4 pb-4  text-lg font-merri tracking-wider text-orange-600 underline underline-offset-4 underline-orange-500">
                                    Sales Items
                                </div>
                                <div class="w-full flex  gap-x-1 pb-4">
                                    @if(\Aaran\Assets\Features\SaleEntry::hasPo_no())
                                        <div class="">
                                            <x-Ui::input.floating id="qty" wire:model.live="po_no" label="Po No"/>
                                        </div>
                                    @endif
                                    @if(\Aaran\Assets\Features\SaleEntry::hasDc_no())
                                        <div class="">
                                            <x-Ui::input.floating id="dc" wire:model.live="dc_no" label="DC No."/>
                                        </div>
                                    @endif
                                    @if(\Aaran\Assets\Features\SaleEntry::hasNo_of_roll())
                                        <div class="">
                                            <x-Ui::input.floating id="no_of_roll" wire:model.live="no_of_roll"
                                                                  label="No of Roll"/>
                                        </div>
                                    @endif
                                    <div class="w-[30%]">
                                        <x-Ui::dropdown.wrapper label="Particulars" type="productTyped">
                                            <div class="relative ">
                                                <x-Ui::dropdown.input label="Product Name" id="product_name"
                                                                      wire:model.live="product_name"
                                                                      wire:keydown.arrow-up="decrementProduct"
                                                                      wire:keydown.arrow-down="incrementProduct"
                                                                      wire:keydown.enter="enterProduct"/>
                                                <x-Ui::dropdown.select>
                                                    @if($productCollection)
                                                        @forelse ($productCollection as $i => $product)
                                                            <x-Ui::dropdown.option
                                                                highlight="{{ $highlightProduct === $i }}"
                                                                wire:click.prevent="setProduct('{{ $product->vname }}', '{{ $product->id }}', '{{ $product->gst_percent_id }}')">
                                                                {{ $product->vname }} &nbsp;-&nbsp;
                                                                GST&nbsp;: {{ $product->gst_percent->vname ?? 'N/A' }}
                                                                %
                                                            </x-Ui::dropdown.option>
                                                        @empty
                                                            @livewire('master::product-modal',[$product_name])
                                                        @endforelse
                                                    @endif
                                                </x-Ui::dropdown.select>
                                            </div>
                                        </x-Ui::dropdown.wrapper>
                                    </div>
                                    @if(\Aaran\Assets\Features\SaleEntry::hasProductDescription())
                                        <div class="w-[20%]">
                                            <x-Ui::input.floating id="qty" wire:model.live="description"
                                                                  label="description"/>
                                        </div>
                                    @endif
                                    @if(\Aaran\Assets\Features\SaleEntry::hasColour())
                                        <div class="w-[15%]">

                                            <x-Ui::dropdown.wrapper label="Colour Name" type="colourTyped">
                                                <div class="relative ">
                                                    <x-Ui::dropdown.input label="Colour Name" id="colour_name"
                                                                          wire:model.live="colour_name"
                                                                          wire:keydown.arrow-up="decrementColour"
                                                                          wire:keydown.arrow-down="incrementColour"
                                                                          wire:keydown.enter="enterColour"/>
                                                    <x-Ui::dropdown.select>
                                                        @if($colourCollection)
                                                            @forelse ($colourCollection as $i => $colour)
                                                                <x-Ui::dropdown.option
                                                                    highlight="{{$highlightColour === $i  }}"
                                                                    wire:click.prevent="setColour('{{$colour->vname}}','{{$colour->id}}')">
                                                                    {{ $colour->vname }}
                                                                </x-Ui::dropdown.option>
                                                            @empty
                                                                <x-Ui::dropdown.new
                                                                    wire:click.prevent="colourSave('{{$colour_name}}')"
                                                                    label="Colour"/>
                                                            @endforelse
                                                        @endif
                                                        {{--                                <x-dropdown.option2  wire:click.prevent="colourSave('{{$colour_name}}')" label="Colour" />--}}

                                                    </x-Ui::Ui::dropdown.select>
                                                </div>
                                            </x-Ui::dropdown.wrapper>
                                        </div>
                                    @endif
                                    @if(\Aaran\Assets\Features\SaleEntry::hasSize())
                                        <div class="w-[15%]">
                                            <x-Ui::dropdown.wrapper label="Size Name" type="sizeTyped">
                                                <div class="relative ">
                                                    <x-Ui::dropdown.input label="Size Name" id="size_name"
                                                                          wire:model.live="size_name"
                                                                          wire:keydown.arrow-up="decrementSize"
                                                                          wire:keydown.arrow-down="incrementSize"
                                                                          wire:keydown.enter="enterSize"/>
                                                    @error('size_id')
                                                    <span
                                                        class="text-red-500">{{'The Size name is Required.'}}</span>
                                                    @enderror
                                                    <x-Ui::dropdown.select>
                                                        @if($sizeCollection)
                                                            @forelse ($sizeCollection as $i => $size)
                                                                <x-Ui::dropdown.option
                                                                    highlight="{{$highlightSize === $i  }}"
                                                                    wire:click.prevent="setSize('{{$size->vname}}','{{$size->id}}')">
                                                                    {{ $size->vname }}
                                                                </x-Ui::dropdown.option>
                                                            @empty
                                                                <x-Ui::dropdown.new
                                                                    wire:click.prevent="sizeSave('{{$size_name}}')"
                                                                    label="Size"/>
                                                            @endforelse
                                                        @endif
                                                        {{--                                <x-dropdown.option2  wire:click.prevent="colourSave('{{$colour_name}}')" label="Size" />--}}

                                                    </x-Ui::dropdown.select>
                                                </div>
                                            </x-Ui::dropdown.wrapper>
                                        </div>
                                    @endif
                                    <div class="w-[10%]">
                                        <x-Ui::input.floating id="qty" wire:model.live="qty" label="Quantity"/>
                                    </div>
                                    <div class="w-[10%]">
                                        <x-Ui::input.floating id="price" wire:model.live="price" label="Price"/>
                                    </div>
                                    <x-Ui::button.add wire:click="addItems"/>
                                </div>
                                <div class="max-w-6xl mx-auto">
                                    <div class="w-full border rounded-lg overflow-hidden">
                                        <table class="w-full text-xs ">
                                            <tr class="bg-zinc-50  text-gray-400 border-b font-medium font-sans tracking-wider">
                                                <th class="py-4 border-r">#</th>
                                                @if(\Aaran\Assets\Features\SaleEntry::hasPo_no())
                                                    <th class="border-r">PO</th>
                                                @endif
                                                @if(\Aaran\Assets\Features\SaleEntry::hasDc_no())
                                                    <th class="border-r">DC</th>
                                                @endif
                                                @if(\Aaran\Assets\Features\SaleEntry::hasNo_of_roll())
                                                    <th class="border-r">No 0f Rolls</th>
                                                @endif
                                                <th class="border-r">Items</th>
                                                @if(\Aaran\Assets\Features\SaleEntry::hasColour())
                                                    <th width="5%" class="border-r">Color</th>
                                                @endif
                                                @if(\Aaran\Assets\Features\SaleEntry::hasSize())
                                                    <th width="4%" class="border-r">Size</th>
                                                @endif
                                                <th width="8%" class="border-r">Quantity</th>
                                                <th width="8%" class="border-r">Rate</th>
                                                <th width="9%" class="border-r">Taxable</th>
                                                <th width="5%" class="border-r">GST Percent</th>
                                                <th width="9%" class="border-r">GST</th>
                                                <th width="9%" class="border-r">Sub Total</th>
                                                <th width="4%">Action</th>
                                            </tr>
                                            @if ($itemList)
                                                @foreach($itemList as $index => $row)
                                                    <tr class="text-center border-b font-lex tracking-wider hover:bg-amber-50">
                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">{{$index+1}}</td>
                                                        @if(\Aaran\Assets\Features\SaleEntry::hasPo_no())
                                                            <td class="py-2 border-r"
                                                                wire:click.prevent="changeItems({{$index}})">{{$row['po_no']}}</td>
                                                        @endif
                                                        @if(\Aaran\Assets\Features\SaleEntry::hasDc_no())
                                                            <td class="py-2 border-r"
                                                                wire:click.prevent="changeItems({{$index}})">{{$row['dc_no']}}</td>
                                                        @endif
                                                        @if(\Aaran\Assets\Features\SaleEntry::hasNo_of_roll())
                                                            <td class="py-2 border-r"
                                                                wire:click.prevent="changeItems({{$index}})">{{$row['no_of_roll']}}</td>
                                                        @endif

                                                        <td class="py-2 border-r text-left px-2"
                                                            wire:click.prevent="changeItems({{$index}})">
                                                            <div class="line-clamp-1">{{$row['product_name']}}
                                                                @if($row['description'])
                                                                    &nbsp;-&nbsp;
                                                                @endif
                                                                @if(\Aaran\Assets\Features\SaleEntry::hasProductDescription())
                                                                    {{ $row['description']}}
                                                                @endif
                                                            </div>
                                                        </td>
                                                        @if(\Aaran\Assets\Features\SaleEntry::hasColour())
                                                            <td class="py-2 border-r"
                                                                wire:click.prevent="changeItems({{$index}})">{{$row['colour_name']}}</td>
                                                        @endif
                                                        @if(\Aaran\Assets\Features\SaleEntry::hasSize())
                                                            <td class="py-2 border-r"
                                                                wire:click.prevent="changeItems({{$index}})">{{$row['size_name']}}</td>
                                                        @endif

                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">{{$row['qty']}}</td>
                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">{{$row['price']}}</td>
                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">{{number_format($row['taxable'],2,'.','')}}</td>
                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">{{$row['gst_percent']}}</td>
                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">{{$row['gst_amount']}}</td>
                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">{{number_format($row['subtotal'],2,'.','')}}</td>
                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">
                                                            <x-Ui::button.delete
                                                                wire:click.prevent="removeItems({{$index}})"/>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr class="bg-zinc-50 text-gray-400 text-center font-sans tracking-wider">
                                                @if(\Aaran\Assets\Features\SaleEntry::hasSize() or \Aaran\Assets\Features\SaleEntry::hasColour())

                                                    <td class="py-2 border-r" colspan="4">TOTALS.</td>
                                                @else
                                                    <td class="py-2 border-r" colspan="4">TOTALS.</td>
                                                @endif
                                                <td class="border-r font-semibold">{{$total_qty}}</td>
                                                <td class="border-r">&nbsp;</td>
                                                <td class="border-r font-semibold">{{number_format($total_taxable,2,'.','')}}</td>
                                                <td class="border-r">&nbsp;</td>
                                                <td class="border-r font-semibold">{{$total_gst}}</td>
                                                <td class="border-r font-semibold">{{number_format($grandtotalBeforeRound,2,'.','')}}</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="max-w-6xl mx-auto flex justify-between items-start gap-5 py-10">
                                <div class="w-2/3">
                                    @if(isset($e_invoiceDetails->id))
                                        <div class="sm:w-full w-[300px] flex flex-col items-center justify-center ">
                                            <img class="w-[200px]"
                                                 src="{{\App\Helper\qrcoder::generate($e_invoiceDetails->signed_qrcode,22)}}"
                                                 alt="{{$e_invoiceDetails->signed_qrcode}}">
                                            <div class="sm:w-full w-[300px]">Irn No
                                                : {{$e_invoiceDetails->irn}}</div>
                                            @if(isset($e_wayDetails))
                                                <div class="sm:w-full w-[300px] ">E-way Bill
                                                    NO: {{$e_wayDetails->ewbno}}</div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="w-1/3 flex text-xs text-400 px-4">
                                    <div class="w-2/4 space-y-4 text-gray-400 font-merri tracking-wider">
                                        <div>Taxable No</div>
                                        <div>GST</div>
                                        <div>Round off</div>
                                        <div class="font-semibold">Grand Total</div>
                                    </div>
                                    <div class="w-1/4 text-center space-y-4 ">
                                        <div>:</div>
                                        <div>:</div>
                                        <div>:</div>
                                        <div>:</div>
                                    </div>
                                    <div class="w-1/4 text-end space-y-4 tracking-wider font-lex">
                                        <div>{{number_format($total_taxable,2,'.','')}}</div>
                                        <div>{{number_format($total_gst,2,'.','')}}</div>
                                        <div>{{$round_off}}</div>
                                        <div class="font-semibold">{{number_format($grand_total,2,'.','')}}</div>
                                    </div>
                                </div>
                            </div>
                        </x-Ui::tabs.content>
                        <x-Ui::tabs.content>
                            <div class="w-1/2 space-y-8 h-52 pt-3">
                                <div>
                                    @if(\Aaran\Assets\Features\SaleEntry::hasBillingAddress())
                                        <x-Ui::dropdown.wrapper label="Billing Address" type="orderTyped">
                                            <div class="relative ">
                                                <x-Ui::dropdown.input label="Billing Address" id="billing_address"
                                                                      wire:model.live="billing_address"
                                                                      wire:keydown.arrow-up="decrementBilling_address"
                                                                      wire:keydown.arrow-down="incrementBilling_address"
                                                                      wire:keydown.enter="enterBilling_address"/>
                                                <x-Ui::dropdown.select>
                                                    @if($billing_addressCollection)
                                                        @forelse ($billing_addressCollection as $i => $billing_address)
                                                            <x-Ui::dropdown.option
                                                                highlight="{{$highlightBilling_address === $i  }}"
                                                                wire:click.prevent="setBilling_address('{{$billing_address->address_type.'-'.$billing_address->address_1}}','{{$billing_address->id}}')">
                                                                {{ $billing_address->address_type }}&nbsp;-&nbsp;
                                                                {{ $billing_address->address_1 }}&nbsp;-&nbsp;
                                                                {{ $billing_address->address_2 }}&nbsp;-&nbsp;
                                                            </x-Ui::dropdown.option>
                                                        @empty
                                                            <x-Ui::dropdown.new
                                                                href="{{route('contacts.upsert',[0])}}"
                                                                label="Billing Address"/>
                                                        @endforelse
                                                    @endif
                                                </x-Ui::dropdown.select>
                                                @error('billing_id')
                                                <span class="text-red-500">{{'Billing Address is Required.'}}</span>
                                                @enderror
                                            </div>
                                        </x-Ui::dropdown.wrapper>
                                    @endif
                                </div>
                                <div>
                                    @if(\Aaran\Assets\Features\SaleEntry::hasShippingAddress())
                                        <x-Ui::dropdown.wrapper label="Shipping Address"
                                                                type="shipping_addressTyped">
                                            <div class="relative ">
                                                <x-Ui::dropdown.input label="Shipping Address" id="shipping_address"
                                                                      wire:model.live="shipping_address"
                                                                      wire:keydown.arrow-up="decrementShipping_address"
                                                                      wire:keydown.arrow-down="incrementShipping_address"
                                                                      wire:keydown.enter="enterShipping_address"/>
                                                <x-Ui::dropdown.select>
                                                    @if($shipping_addressCollection)
                                                        @forelse ($shipping_addressCollection as $i => $shipping_address)
                                                            <x-Ui::dropdown.option
                                                                highlight="{{$highlightShipping_address === $i  }}"
                                                                wire:click.prevent="setShipping_address('{{ $shipping_address->address_type.'-'. $shipping_address->address_1}}','{{$shipping_address->id}}')">
                                                                {{ $shipping_address->address_type }}&nbsp;-&nbsp;
                                                                {{ $shipping_address->address_1 }}&nbsp;-&nbsp;
                                                                {{ $shipping_address->address_2 }}&nbsp;-&nbsp;
                                                            </x-Ui::dropdown.option>
                                                        @empty
                                                            <x-Ui::dropdown.new
                                                                href="{{route('contacts.upsert',[0])}}"
                                                                label="Shipping Address"/>
                                                        @endforelse
                                                    @endif
                                                </x-Ui::dropdown.select>
                                                @error('shipping_id')
                                                <span
                                                    class="text-red-500">{{'Shipping Address is Required.'}}</span>
                                                @enderror
                                            </div>
                                        </x-Ui::dropdown.wrapper>
                                    @endif
                                </div>
                                {{--                          <div>{{$billing_address->address_1, $billing_address->address_2}}</div>--}}

                            </div>
                        </x-Ui::tabs.content>

                        <x-Ui::tabs.content>
                            <div class="flex justify-between gap-5 h-56 pt-3">
                                <div class="w-full space-y-8 ">

                                    @if(\Aaran\Assets\Features\SaleEntry::hasTransport())
                                        <x-Ui::dropdown.wrapper label="Transport" type="transportTyped">
                                            <div class="relative ">
                                                <x-Ui::dropdown.input label="Transport" id="transport_name"
                                                                      wire:model="transport_id"
                                                                      wire:model.live="transport_name"
                                                                      wire:keydown.arrow-up="decrementTransport"
                                                                      wire:keydown.arrow-down="incrementTransport"
                                                                      wire:keydown.enter="enterTransport"/>

                                                <x-Ui::dropdown.select>
                                                    @if($transportCollection)
                                                        @forelse ($transportCollection as $i => $transport)
                                                            <x-Ui::dropdown.option
                                                                highlight="{{$highlightTransport === $i  }}"
                                                                wire:click.prevent="setTransport('{{$transport->vname}}','{{$transport->id}}')">
                                                                {{ $transport->vname }}
                                                            </x-Ui::dropdown.option>
                                                        @empty
                                                            <x-Ui::dropdown.new
                                                                wire:click.prevent="transportSave('{{$transport_name}}')"
                                                                label="Transport"/>
                                                        @endforelse
                                                    @endif
                                                </x-Ui::dropdown.select>
                                                @error('transport_id')
                                                <span class="text-red-400">Transport is Required</span>
                                                @enderror
                                                @error('transport_name')
                                                <span class="text-red-400">Transport Name is Required</span>
                                                @enderror
                                            </div>
                                        </x-Ui::dropdown.wrapper>
                                    @endif

                                    <x-Ui::input.model-date wire:model="TransdocDt" label="Transport Date"/>
                                    <x-Ui::input.model-select wire:model="TransMode" label="Transport Mode">
                                        <option value="">Choose..</option>
                                        <option value="1">Road</option>
                                        <option value="2">Rail</option>
                                        <option value="3">Air</option>
                                        <option value="4">ship</option>
                                    </x-Ui::input.model-select>

                                </div>
                                <div class="w-full space-y-8">
                                    <div>
                                        <x-Ui::input.floating wire:model.live="distance" label="Distance"/>
                                        @error('distance')
                                        <span class="text-red-400">{{$message}}</span>@enderror
                                    </div>
                                    <div>
                                        <x-Ui::input.floating wire:model.live="Vehno" label="Vehicle No"/>
                                        @error('Vehno')
                                        <span class="text-red-400">{{$message}}</span>@enderror
                                    </div>
                                    <x-Ui::input.model-select wire:model="Vehtype" label="Vechile Type">
                                        <option value="">Choose..</option>
                                        <option value="R">Regular</option>
                                        <option value="O">ODC</option>
                                    </x-Ui::input.model-select>

                                </div>
                            </div>
                        </x-Ui::tabs.content>

                        <x-Ui::tabs.content>
                            <div class="w-1/2 space-y-8 gap-5 h-52 pt-3">

                                @if(\Aaran\Assets\Features\SaleEntry::hasDestination())
                                    <x-Ui::input.floating wire:model="destination" label="Destination"/>
                                @endif
                                @if(\Aaran\Assets\Features\SaleEntry::hasBundle())
                                    <x-Ui::input.floating wire:model="bundle" label="Bundle"/>
                                @endif
                            </div>
                        </x-Ui::tabs.content>
                        <x-Ui::tabs.content>
                            <div class="w-1/2 space-y-8 h-52 pt-3">
                                <!-- Ledger ----------------------------------------------------------------------------------->
                                <x-Ui::dropdown.wrapper label="Ledger" type="ledgerTyped">
                                    <div class="relative ">
                                        <x-Ui::dropdown.input label="Ledger" id="ledger_name"
                                                              wire:model.live="ledger_name"
                                                              wire:keydown.arrow-up="decrementLedger"
                                                              wire:keydown.arrow-down="incrementLedger"
                                                              wire:keydown.enter="enterLedger"/>
                                        @error('ledger_id')
                                        <span class="text-red-500">{{'The Ledger is Required.'}}</span>
                                        @enderror
                                        <x-Ui::dropdown.select>
                                            @if($ledgerCollection)
                                                @forelse ($ledgerCollection as $i => $ledger)
                                                    <x-Ui::dropdown.option highlight="{{$highlightLedger === $i  }}"
                                                                           wire:click.prevent="setLedger('{{$ledger->vname}}','{{$ledger->id}}')">
                                                        {{ $ledger->vname }}
                                                    </x-Ui::dropdown.option>
                                                @empty
                                                    <x-Ui::dropdown.new
                                                        wire:click.prevent="ledgerSave('{{$ledger_name}}')"
                                                        label="Ledger"/>
                                                @endforelse
                                            @endif
                                        </x-Ui::dropdown.select>
                                    </div>
                                </x-Ui::dropdown.wrapper>

                                <x-Ui::input.floating wire:model="additional" wire:change.debounce="calculateTotal"
                                                      label="Addition"
                                                      class="text-right block px-2.5 pb-2.5 pt-4 w-full text-sm
                                                      text-gray-900 bg-transparent rounded-lg border-1
                                                       border-gray-300 appearance-none
                                                       focus:outline-none focus:ring-2 focus:ring-cyan-50 focus:border-blue-600 peer"/>
                            </div>
                        </x-Ui::tabs.content>
                        <x-Ui::tabs.content>
                            <div class="w-1/2">
                                <x-Ui::input.rich-text wire:model="term" placeholder="Terms & Conditions"/>
                            </div>
                        </x-Ui::tabs.content>

                    </x-slot>
                </x-Ui::tabs.tab-panel>
            </div>
        </div>

        <div class="max-w-6xl mx-auto">
            @if( $vid != "")
                <x-Ui::forms.m-panel-bottom-button save back/>
            @else
                <x-Ui::forms.m-panel-bottom-button save print back/>
            @endif
        </div>
    </div>
    {{--    </x-Ui::forms.m-panel>--}}
</div>
<script>
    Livewire.on('triggerFocusNextTab', () => {
        document.querySelector('[x-ref="nextInput"]')?.focus();
    });

    Livewire.on('triggerFocusOrder', () => {
        document.querySelector('[x-ref="order_name"]')?.focus();
    });

</script>
