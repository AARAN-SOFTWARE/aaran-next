<div>
    <x-slot name="header">Sales</x-slot>
    {{--    <x-Ui::forms.m-panel>--}}
    <x-Ui::alerts.notification/>

    <div class="pt-4 min-h-[40rem]">
        <div class="space-y-3">
            <div class="max-w-7xl mx-auto">
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

                        <!--  TAB 1 - Details ------------------------------------------------------------------------------------------------->

                        <x-Ui::tabs.content>

                            <div class="space-y-5 py-3">
                                <div class="w-full flex gap-5 ">

                                    <div class="w-full space-y-5">

                                        <div>
                                            @livewire('master::contact.lookup',['initId' => $form->contact_id] )
                                            <x-Ui::input.error-text wire:model="form.contact_id"/>
                                        </div>

                                        <div>
                                            @if(\Aaran\Assets\Features\SaleEntry::hasOrder())
                                                @livewire('master::order.lookup',['initId' => $form->order_id])
                                                <x-Ui::input.error-text wire:model="form.order_id"/>
                                            @endif
                                        </div>

                                        <div>

                                            @if(\Aaran\Assets\Features\SaleEntry::hasStyle())
                                                @livewire('master::style.lookup',['initId' => $form->order_id])
                                                <x-Ui::input.error-text wire:model="form.style_id"/>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="w-full space-y-5 ">
                                        <div>
                                            <x-Ui::input.floating wire:model="form.invoice_no" label="Invoice No"/>
                                            <x-Ui::input.error-text wire:model="form.invoice_no"/>
                                        </div>
                                        <div>
                                            <x-Ui::input.model-date wire:model="form.invoice_date"
                                                                    label="Invoice Date"/>
                                            <x-Ui::input.error-text wire:model="form.invoice_date"/>
                                        </div>
                                        <div>
                                            <x-Ui::input.model-select wire:model="form.sales_type"
                                                                      :label="'Sales Type'">
                                                <option value="0" class="text-gray-400"> choose ..</option>
                                                <option value="1">CGST-SGST</option>
                                                <option value="2">IGST</option>
                                            </x-Ui::input.model-select>
                                            <x-Ui::input.error-text wire:model="form.sales_type"/>
                                        </div>
                                        <div>
                                            @if(\Aaran\Assets\Features\SaleEntry::hasJob_no())
                                                <x-Ui::input.floating wire:model="form.job_no" label="Job No"/>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <!-- Add sales item ------------------------------------------------------------------------------------------------->

                                <div
                                    class="px-4 pb-4  text-lg font-merri tracking-wider text-orange-600 underline underline-offset-4 underline-orange-500">
                                    Sales Items
                                </div>
                                <div class="w-full flex  gap-x-1 pb-4">

                                    @if(\Aaran\Assets\Features\SaleEntry::hasPo_no())
                                        <div class="">
                                            <x-Ui::input.floating id="qty" wire:model="itemForm.po_no" label="Po No"/>
                                        </div>
                                    @endif
                                    @if(\Aaran\Assets\Features\SaleEntry::hasDc_no())
                                        <div class="">
                                            <x-Ui::input.floating id="dc" wire:model="itemForm.dc_no" label="DC No."/>
                                        </div>
                                    @endif

                                    <div class="w-[30%]">
                                        @livewire('master::product.lookup',['initId' => $itemForm->product_id])

                                    </div>

                                    @if(\Aaran\Assets\Features\SaleEntry::hasProductDescription())
                                        <div class="w-[20%]">
                                            <x-Ui::input.floating id="description" wire:model="itemForm.description"
                                                                  label="description"/>
                                        </div>
                                    @endif
                                    @if(\Aaran\Assets\Features\SaleEntry::hasColour())
                                        <div class="w-[15%]">
                                            @livewire('common::lookup.colour',['initId' => $itemForm->colour_id])
                                        </div>
                                    @endif
                                    @if(\Aaran\Assets\Features\SaleEntry::hasSize())
                                        <div class="w-[15%]">
                                            @livewire('common::lookup.size',['initId' => $itemForm->size_id])
                                        </div>
                                    @endif
                                    @if(\Aaran\Assets\Features\SaleEntry::hasNo_of_roll())
                                        <div class="w-[10%]">
                                            <x-Ui::input.floating id="no_of_roll" wire:model="itemForm.no_of_roll"
                                                                  label="No of Roll"/>
                                        </div>
                                    @endif
                                    <div class="w-[10%]">
                                        <x-Ui::input.floating id="qty" wire:model="itemForm.qty" label="Quantity"/>
                                    </div>
                                    <div class="w-[10%]">
                                        <x-Ui::input.floating id="price" wire:model="itemForm.price" label="Price"/>
                                    </div>
                                    <x-Ui::button.add wire:click.prevent="addItems"/>
                                </div>


                                <!--  sales item table ------------------------------------------------------------------------------------------------->


                                <div class="max-w-7xl mx-auto">
                                    <div class="w-full border rounded-lg overflow-hidden">
                                        <table class="w-full text-xs ">
                                            <tr class="bg-neutral-50  text-neutral-400 border-b font-medium font-sans tracking-wider">
                                                <th class="py-4 border-r">#</th>
                                                @if(\Aaran\Assets\Features\SaleEntry::hasPo_no())
                                                    <th class="border-r">PO</th>
                                                @endif
                                                @if(\Aaran\Assets\Features\SaleEntry::hasDc_no())
                                                    <th class="border-r">DC</th>
                                                @endif

                                                <th class="border-r">Items</th>

                                                @if(\Aaran\Assets\Features\SaleEntry::hasColour())
                                                    <th width="5%" class="border-r">Color</th>
                                                @endif
                                                @if(\Aaran\Assets\Features\SaleEntry::hasSize())
                                                    <th width="4%" class="border-r">Size</th>
                                                @endif
                                                @if(\Aaran\Assets\Features\SaleEntry::hasNo_of_roll())
                                                    <th width="5%" class="border-r">No 0f Rolls</th>
                                                @endif
                                                <th width="8%" class="border-r">Quantity</th>
                                                <th width="8%" class="border-r">Rate</th>
                                                <th width="8%" class="border-r">Taxable</th>
                                                <th width="4%" class="border-r">GST Percent</th>
                                                <th width="8%" class="border-r">GST</th>
                                                <th width="8%" class="border-r">Sub Total</th>
                                                <th width="4%">Action</th>
                                            </tr>
                                            @if ($itemForm->itemList)
                                                @foreach($itemForm->itemList as $index => $row)
                                                    <tr class="text-center border-b font-lex tracking-wider hover:bg-amber-50">
                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">{{(int)$index+1}}</td>
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
                                                                @if(\Aaran\Assets\Features\SaleEntry::hasProductDescription() && !empty($row['description']))
                                                                    &nbsp;-&nbsp; {{ $row['description'] }}
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
                                                            wire:click.prevent="changeItems({{$index}})">{{ \Aaran\Assets\Helper\Format::Decimal($row['taxable'])}}</td>
                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">{{$row['gst_percent']}}</td>
                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">{{\Aaran\Assets\Helper\Format::Decimal($row['gst_amount'])}}</td>
                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">{{\Aaran\Assets\Helper\Format::Decimal($row['subtotal'])}}</td>
                                                        <td class="py-2 border-r"
                                                            wire:click.prevent="changeItems({{$index}})">
                                                            <x-Ui::button.delete
                                                                wire:click.prevent="removeItems({{$index}})"/>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif


                                            <!--  Bottom Total ------------------------------------------------------------------------------------------------->


                                            <tr class="bg-neutral-50 text-neutral-400 text-center font-sans tracking-wider">

                                                @if (\Aaran\Assets\Features\SaleEntry::hasNo_of_roll() && \Aaran\Assets\Features\SaleEntry::hasSize() && \Aaran\Assets\Features\SaleEntry::hasColour())
                                                    <td class="py-2 border-r" colspan="7">TOTALS.</td>
                                                @elseif (\Aaran\Assets\Features\SaleEntry::hasSize() && \Aaran\Assets\Features\SaleEntry::hasColour())
                                                    <td class="py-2 border-r" colspan="6">TOTALS.</td>
                                                @else
                                                    <td class="py-2 border-r" colspan="4">TOTALS.</td>
                                                @endif

                                                <td class="border-r font-semibold">{{$form->total_qty ??'' }}</td>
                                                <td class="border-r">&nbsp;</td>
                                                <td class="border-r font-semibold">{{\Aaran\Assets\Helper\Format::Decimal($form->total_taxable)}}</td>
                                                <td class="border-r">&nbsp;</td>
                                                <td class="border-r font-semibold">{{ \Aaran\Assets\Helper\Format::Decimal($form->total_gst)}}</td>
                                                <td class="border-r font-semibold">{{\Aaran\Assets\Helper\Format::Decimal($grandTotalBeforeRound)}}</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!--  Bottom Total ------------------------------------------------------------------------------------------------->

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
                                        <div>{{\Aaran\Assets\Helper\Format::Decimal($form->total_taxable)}}</div>
                                        <div>{{\Aaran\Assets\Helper\Format::Decimal($form->total_gst)}}</div>
                                        <div>{{$form->round_off}}</div>
                                        <div
                                            class="font-semibold">{{\Aaran\Assets\Helper\Format::Decimal($form->grand_total)}}</div>
                                    </div>
                                </div>
                            </div>
                        </x-Ui::tabs.content>


                        <!--  TAB 2 - Address ------------------------------------------------------------------------------------------------->


                        <x-Ui::tabs.content>
                            <div class="w-1/2 space-y-8 h-52 pt-3">
                                <div>
                                    @if(\Aaran\Assets\Features\SaleEntry::hasBillingAddress())
                                        @livewire('master::contact.address',['initId' => $form->billing_id,'label'=>'Billing Address'],
                                                    key('contact-billing-address-' .$form->billing_id))
                                        <x-Ui::input.error-text wire:model="form.billing_id"/>
                                    @endif
                                </div>
                                <div>
                                    @if(\Aaran\Assets\Features\SaleEntry::hasShippingAddress())
                                        @livewire('master::contact.address',['initId' => $form->order_id ,'label'=>'Shipping Address'],
                                                    key('contact-shipping-address-' .$form->shipping_id))
                                        <x-Ui::input.error-text wire:model="form.shipping_id"/>
                                    @endif
                                </div>

                            </div>
                        </x-Ui::tabs.content>

                        <x-Ui::tabs.content>
                            <div class="flex justify-between gap-5 h-56 pt-3">
                                <div class="w-full space-y-8 ">

                                    @if(\Aaran\Assets\Features\SaleEntry::hasTransport())

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

        <div class="max-w-7xl mx-auto">
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
