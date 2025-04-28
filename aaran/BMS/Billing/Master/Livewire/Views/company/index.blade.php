<div>
    <x-slot name="header">Company</x-slot>

    <x-Ui::forms.m-panel>
        <x-Ui::alerts.notification/>

        <!-- Top Controls --------------------------------------------------------------------------------------------->

        <x-Ui::forms.top-controls :show-filters="$showFilters"/>

        <!-- Top Controls --------------------------------------------------------------------------------------------->

        <x-Ui::table.caption :caption="'Company'">
            {{$list->count()}}
        </x-Ui::table.caption>

        <!-- Table Header --------------------------------------------------------------------------------------------->

        <x-Ui::table.form>
            <x-slot:table_header name="table_header" class="bg-green-600">

                <x-Ui::table.header-serial width="20%"/>

                <x-Ui::table.header-text wire:click.prevent="sortBy('vname')" sortIcon="{{$sortAsc}}">
                    Company&nbsp;Name
                </x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">GST</x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">Mobile</x-Ui::table.header-text>

                <x-Ui::table.header-text sortIcon="none">Address</x-Ui::table.header-text>


                <x-Ui::table.header-action/>
            </x-slot:table_header>

            <!-- Table Body ------------------------------------------------------------------------------------------->

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)
                    <x-Ui::table.row>
                        <x-Ui::table.cell-text>{{$index+1}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->vname}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->gstin}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text>{{$row->mobile}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-text left>{{$row->address_1}}</x-Ui::table.cell-text>
                        <x-Ui::table.cell-action id="{{$row->id}}"/>
                    </x-Ui::table.row>
                @endforeach

            </x-slot:table_body>

        </x-Ui::table.form>

        <!-- Delete Modal --------------------------------------------------------------------------------------------->
        <x-Ui::modal.confirm-delete/>
        {{--        <div class="">{{ $list->links() }}</div>--}}



        <!-- Create --------------------------------------------------------------------------------------------------->

        <x-Ui::forms.create :id="$vid" :max-width="'6xl'">
            <div class="h-[38rem]">
                <!-- Tab Header --------------------------------------------------------------------------------------->
                <x-Ui::tabs.tab-panel>

                    <x-slot name="tabs">
                        <x-Ui::tabs.tab>Mandatory</x-Ui::tabs.tab>
                        <x-Ui::tabs.tab>Address</x-Ui::tabs.tab>
                        <x-Ui::tabs.tab>Logo</x-Ui::tabs.tab>
                        <x-Ui::tabs.tab>Bank</x-Ui::tabs.tab>
                        <x-Ui::tabs.tab>Detailing</x-Ui::tabs.tab>
                    </x-slot>

                    <x-slot name="content">

                        <!-- Tab 1 ------------------------------------------------------------------------------------>

                        <x-Ui::tabs.content>
                            <div class="flex flex-col gap-3">

                                <div>
                                    <x-Ui::input.floating wire:model.live="vname" label="Name"/>
                                    <x-Ui::input.error-text wire:model="vname"/>
                                </div>

                                <x-Ui::input.floating wire:model="display_name" label="Display-name"/>
                                <x-Ui::input.floating wire:model="mobile" label="Mobile"/>
                                <x-Ui::input.floating wire:model="landline" label="Landline"/>

                                <div>
                                    <x-Ui::input.floating wire:model.live="gstin" label="GSTin"/>
                                    <x-Ui::input.error-text wire:model="gstin"/>
                                </div>

                                <x-Ui::input.floating wire:model="pan" label="Pan"/>
                                <x-Ui::input.floating wire:model="email" label="Email"/>
                                <x-Ui::input.floating wire:model="website" label="Website"/>
                            </div>
                        </x-Ui::tabs.content>

                        <!-- Tab 2 ------------------------------------------------------------------------------------>

                        <x-Ui::tabs.content>
                            <div class="flex flex-col gap-3">

                                <div>
                                    <x-Ui::input.floating wire:model.live="address_1" label="Address"/>
                                    <x-Ui::input.error-text wire:model="address_1"/>
                                </div>

                                <div>
                                    <x-Ui::input.floating wire:model.live="address_2" label="Area-Road"/>
                                    <x-Ui::input.error-text wire:model="address_2"/>
                                </div>

                                <!-- City ----------------------------------------------------------------------------->

                                <x-Ui::dropdown.wrapper label="City" type="cityTyped">
                                    <div class="relative ">
                                        <x-Ui::dropdown.input label="City" id="city_name"
                                                              wire:model.live="city_name"
                                                              wire:keydown.arrow-up="decrementCity"
                                                              wire:keydown.arrow-down="incrementCity"
                                                              wire:keydown.enter="enterCity"/>
                                        <x-Ui::dropdown.select>
                                            @if($cityCollection)
                                                @forelse ($cityCollection as $i => $city)
                                                    <x-Ui::dropdown.option highlight="{{$highlightCity === $i  }}"
                                                                           wire:click.prevent="setCity('{{$city->vname}}','{{$city->id}}')">
                                                        {{ $city->vname }}
                                                    </x-Ui::dropdown.option>
                                                @empty
                                                    <x-Ui::dropdown.create
                                                        wire:click.prevent="citySave('{{$city_name}}')" label="City"/>
                                                @endforelse
                                            @endif
                                        </x-Ui::dropdown.select>
                                    </div>
                                    <x-Ui::input.error-text wire:model="city_name"/>
                                </x-Ui::dropdown.wrapper>

                                <!-- State ---------------------------------------------------------------------------->

                                <x-Ui::dropdown.wrapper label="State" type="stateTyped">
                                    <div class="relative ">
                                        <x-Ui::dropdown.input label="State" id="state_name"
                                                              wire:model.live="state_name"
                                                              wire:keydown.arrow-up="decrementState"
                                                              wire:keydown.arrow-down="incrementState"
                                                              wire:keydown.enter="enterState"/>
                                        <x-Ui::dropdown.select>
                                            @if($stateCollection)
                                                @forelse ($stateCollection as $i => $states)
                                                    <x-Ui::dropdown.option highlight="{{$highlightState === $i  }}"
                                                                           wire:click.prevent="setState('{{$states->vname}}','{{$states->id}}')">
                                                        {{ $states->vname }}
                                                    </x-Ui::dropdown.option>
                                                @empty
                                                    <x-Ui::dropdown.create
                                                        wire:click.prevent="stateSave('{{ $state_name }}')"
                                                        label="State"/>
                                                @endforelse
                                            @endif
                                        </x-Ui::dropdown.select>
                                    </div>
                                    <x-Ui::input.error-text wire:model="state_name"/>
                                </x-Ui::dropdown.wrapper>

                                <!-- Pin-code ------------------------------------------------------------------------->

                                <x-Ui::dropdown.wrapper label="Pincode" type="pincodeTyped">
                                    <div class="relative ">
                                        <x-Ui::dropdown.input label="Pincode" id="pincode_name"
                                                              wire:model.live="pincode_name"
                                                              wire:keydown.arrow-up="decrementPincode"
                                                              wire:keydown.arrow-down="incrementPincode"
                                                              wire:keydown.enter="enterPincode"/>
                                        <x-Ui::dropdown.select>
                                            @if($pincodeCollection)
                                                @forelse ($pincodeCollection as $i => $pincode)
                                                    <x-Ui::dropdown.option highlight="{{$highlightPincode === $i  }}"
                                                                           wire:click.prevent="setPincode('{{$pincode->vname}}','{{$pincode->id}}')">
                                                        {{ $pincode->vname }}
                                                    </x-Ui::dropdown.option>
                                                @empty
                                                    <x-Ui::dropdown.create
                                                        wire:click.prevent="pincodeSave('{{$pincode_name}}')"
                                                        label="Pincode"/>
                                                @endforelse
                                            @endif
                                        </x-Ui::dropdown.select>
                                    </div>
                                    <x-Ui::input.error-text wire:model="pincode_name"/>
                                </x-Ui::dropdown.wrapper>

                                <!-- country ------------------------------------------------------------------------->
                                <x-Ui::dropdown.wrapper label="Country" type="countryTyped">
                                    <div class="relative">
                                        <x-Ui::dropdown.input label="Country" id="country_name"
                                                              wire:model.live="country_name"
                                                              wire:keydown.arrow-up="decrementCountry"
                                                              wire:keydown.arrow-down="incrementCountry"
                                                              wire:keydown.enter="enterCountry"/>
                                        <x-Ui::dropdown.select>
                                            @if($countryCollection)
                                                @forelse ($countryCollection as $i => $country)
                                                    <x-Ui::dropdown.option highlight="{{$highlightCountry === $i}}"
                                                                           wire:click.prevent="setCountry('{{$country->vname}}','{{$country->id}}')">
                                                        {{ $country->vname }}
                                                    </x-Ui::dropdown.option>
                                                @empty
                                                    <x-Ui::dropdown.create
                                                        wire:click.prevent="countrySave('{{$country_name}}')"
                                                        label="Country"/>
                                                @endforelse
                                            @endif
                                        </x-Ui::dropdown.select>
                                    </div>
                                    <x-Ui::input.error-text wire:model="country_name"/>
                                </x-Ui::dropdown.wrapper>

                            </div>
                        </x-Ui::tabs.content>

                        <!-- Tab 3 ------------------------------------------------------------------------------------>

                        <x-Ui::tabs.content>
                            <div class="flex flex-col py-2">
                                <label for="bg_image"
                                       class="w-full text-zinc-500 tracking-wide pb-4 px-2">Company Logo</label>

                                <div class="flex flex-wrap sm:gap-6 gap-2">
                                    <div class="flex-shrink-0">
                                        <div>
                                            @if($logo)
                                                <div
                                                    class=" flex-shrink-0 bg-blue-100 p-1 rounded-lg overflow-hidden">
                                                    <img
                                                        class="w-[156px] h-[89px] rounded-lg hover:brightness-110 hover:scale-105 duration-300 transition-all ease-out"
                                                        src="{{ $logo->temporaryUrl() }}"
                                                        alt="{{$logo?:''}}"/>
                                                </div>
                                            @endif

                                            @if(!$logo && isset($logo))
                                                <img class="h-24 w-full"
                                                     src="{{URL(\Illuminate\Support\Facades\Storage::url('images/'.$old_logo))}}"
                                                     alt="">
                                            @else
                                                <x-Ui::icons.icon :icon="'logo'" class="w-auto h-auto block "/>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <div>
                                            <label for="bg_image"
                                                   class="text-gray-500 font-semibold text-base rounded flex flex-col items-center
                                   justify-center cursor-pointer border-2 border-gray-300 border-dashed p-2
                                   mx-auto font-[sans-serif]">
                                                <x-Ui::icons.icon icon="cloud-upload"
                                                                  class="w-8 h-auto block text-gray-400"/>
                                                Upload Photo
                                                <input type="file" id='bg_image' wire:model="logo" class="hidden"/>
                                                <p class="text-xs font-light text-gray-400 mt-2">PNG and JPG are
                                                    Allowed.</p>
                                            </label>
                                        </div>

                                        <div wire:loading wire:target="logo" class="z-10 absolute top-6 left-12">
                                            <div class="w-14 h-14 rounded-full animate-spin
                                                        border-y-4 border-dashed border-green-500 border-t-transparent"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </x-Ui::tabs.content>

                        <!-- Tab 4 ------------------------------------------------------------------------------------>

                        <x-Ui::tabs.content>
                            <div class="flex flex-col gap-3">

                                <!-- Bank Details --------------------------------------------------------------------->

                                <x-Ui::input.floating wire:model="acc_no" label="Account No"/>
                                <x-Ui::input.floating wire:model="ifsc_code" label="IFSC Code"/>
                                <x-Ui::input.floating wire:model="bank" label="Bank"/>
                                <x-Ui::input.floating wire:model="branch" label="Branch"/>
                                <x-Ui::input.floating wire:model.live="inv_pfx" label="Invoice Prefix"/>
                                <x-Ui::input.floating wire:model.live="iec_no" label="IEC No"/>
                            </div>
                        </x-Ui::tabs.content>

                        <!-- Tab 5 ------------------------------------------------------------------------------------>

                        <x-Ui::tabs.content>

                            <div class="flex flex-col gap-3">
                                <x-Ui::input.floating wire:model="msme_no" label="MSME No"/>

                                <x-Ui::dropdown.wrapper label="MSME Type" type="MsmeTypeTyped">
                                    <div class="relative ">
                                        <x-Ui::dropdown.input label="MSME Type" id="msme_type_name"
                                                              wire:model.live="msme_type_name"
                                                              wire:keydown.arrow-up="decrementMsmeType"
                                                              wire:keydown.arrow-down="incrementMsmeType"
                                                              wire:keydown.enter="enterMsmeType"/>

                                        <x-Ui::dropdown.select wire:model="msme_type_id">
                                            @if($msmeTypeCollection)
                                                @foreach ($msmeTypeCollection as $msmeType)
                                                    <x-Ui::dropdown.option
                                                        :highlight="$highlightMsmeType === $loop->index"
                                                        wire:click.prevent="setMsmeType('{{ $msmeType['id'] }}')">
                                                        {{ $msmeType['vname'] }}
                                                    </x-Ui::dropdown.option>
                                                @endforeach
                                            @endif
                                        </x-Ui::dropdown.select>

                                    </div>
                                </x-Ui::dropdown.wrapper>

                                {{--                                <x-Ui::input.floating wire:model="msme_type" label="MSME Type" />--}}
                            </div>
                        </x-Ui::tabs.content>
                    </x-slot>
                </x-Ui::tabs.tab-panel>
            </div>
        </x-Ui::forms.create>

        <!-- Actions ------------------------------------------------------------------------------------------->

    </x-Ui::forms.m-panel>

</div>
