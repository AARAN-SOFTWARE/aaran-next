<div>
    <x-slot name="header">Company</x-slot>

    <x-aaran-ui::forms.m-panel>
        <x-aaran-ui::alerts.notification />

        <!-- Top Controls --------------------------------------------------------------------------------------------->

        <x-aaran-ui::forms.top-controls :show-filters="$showFilters"/>

        <!-- Top Controls --------------------------------------------------------------------------------------------->

        <x-aaran-ui::table.caption :caption="'Company'">
            {{$list->count()}}
        </x-aaran-ui::table.caption>

        <!-- Table Header --------------------------------------------------------------------------------------------->

        <x-aaran-ui::table.form>
            <x-slot:table_header name="table_header" class="bg-green-600">

                <x-aaran-ui::table.header-serial width="20%"/>

                <x-aaran-ui::table.header-text wire:click.prevent="sortBy('vname')" sortIcon="{{$getListForm->sortAsc}}">
                    Company&nbsp;Name
                </x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text sortIcon="none">GST</x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text sortIcon="none">Mobile</x-aaran-ui::table.header-text>

                <x-aaran-ui::table.header-text sortIcon="none">Address</x-aaran-ui::table.header-text>


                <x-aaran-ui::table.header-action/>
            </x-slot:table_header>

            <!-- Table Body ------------------------------------------------------------------------------------------->

            <x-slot:table_body name="table_body">

                @foreach($list as $index=>$row)
                    <x-aaran-ui::table.row>
                        <x-aaran-ui::table.cell-text>{{$index+1}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text left>{{$row->vname}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text>{{$row->gstin}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text>{{$row->mobile}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-text left>{{$row->address_1}}</x-aaran-ui::table.cell-text>
                        <x-aaran-ui::table.cell-action id="{{$row->id}}"/>
                    </x-aaran-ui::table.row>
                @endforeach

            </x-slot:table_body>

        </x-aaran-ui::table.form>

        <x-aaran-ui::modal.delete/>
{{--        <div class="">{{ $list->links() }}</div>--}}



        <!-- Create --------------------------------------------------------------------------------------------------->

        <x-aaran-ui::forms.create :id="$common->vid" :max-width="'6xl'">
            <div class="h-[38rem]">
                <!-- Tab Header --------------------------------------------------------------------------------------->
                <x-aaran-ui::tabs.tab-panel>

                    <x-slot name="tabs">
                        <x-aaran-ui::tabs.tab>Mandatory</x-aaran-ui::tabs.tab>
                        <x-aaran-ui::tabs.tab>Address</x-aaran-ui::tabs.tab>
                        <x-aaran-ui::tabs.tab>Logo</x-aaran-ui::tabs.tab>
                        <x-aaran-ui::tabs.tab>Bank</x-aaran-ui::tabs.tab>
                        <x-aaran-ui::tabs.tab>Detailing</x-aaran-ui::tabs.tab>
                    </x-slot>

                    <x-slot name="content">

                        <!-- Tab 1 ------------------------------------------------------------------------------------>

                        <x-aaran-ui::tabs.content>
                            <div class="flex flex-col gap-3" >
                                <x-aaran-ui::input.floating wire:model.live="common.vname" label="Name"/>
                                @error('common.vname')
                                <span class="text-red-400 text-xs">{{$message}}</span>
                                @enderror
                                <x-aaran-ui::input.floating wire:model="display_name" label="Display-name"/>
                                <x-aaran-ui::input.floating wire:model="mobile" label="Mobile"/>
                                <x-aaran-ui::input.floating wire:model="landline" label="Landline"/>
                                <x-aaran-ui::input.floating wire:model.live="gstin" label="GSTin"/>
                                @error('gstin')
                                <span class="text-red-400">{{$message}}</span>
                                @enderror
                                <x-aaran-ui::input.floating wire:model="pan" label="Pan"/>
                                <x-aaran-ui::input.floating wire:model="email" label="Email"/>
                                <x-aaran-ui::input.floating wire:model="website" label="Website"/>
                            </div>
                        </x-aaran-ui::tabs.content>

                        <!-- Tab 2 ------------------------------------------------------------------------------------>

                        <x-aaran-ui::tabs.content>
                            <div class="flex flex-col gap-3">
                                <x-aaran-ui::input.floating wire:model.live="address_1" label="Address" />
                                @error('address_1')
                                <span class="text-red-400 text-xs">{{$message}}</span>
                                @enderror
                                <x-aaran-ui::input.floating wire:model.live="address_2" label="Area-Road" />
                                @error('address_2')
                                <span class="text-red-400 text-xs">{{$message}}</span>
                                @enderror

                                <!-- City ----------------------------------------------------------------------------->

                                <x-aaran-ui::dropdown.wrapper label="City" type="cityTyped">
                                    <div class="relative ">
                                        <x-aaran-ui::dropdown.input label="City" id="city_name"
                                                          wire:model.live="city_name"
                                                          wire:keydown.arrow-up="decrementCity"
                                                          wire:keydown.arrow-down="incrementCity"
                                                          wire:keydown.enter="enterCity"/>
                                        <x-aaran-ui::dropdown.select>
                                            @if($cityCollection)
                                                @forelse ($cityCollection as $i => $city)
                                                    <x-aaran-ui::dropdown.option highlight="{{$highlightCity === $i  }}"
                                                                       wire:click.prevent="setCity('{{$city->vname}}','{{$city->id}}')">
                                                        {{ $city->vname }}
                                                    </x-aaran-ui::dropdown.option>
                                                @empty
                                                    <x-aaran-ui::dropdown.create  wire:click.prevent="citySave('{{$city_name}}')" label="City" />
                                                @endforelse
                                            @endif
                                        </x-aaran-ui::dropdown.select>
                                    </div>
                                </x-aaran-ui::dropdown.wrapper>
                                @error('city_name')
                                <span class="text-red-400 text-xs">{{$message}}</span>
                                @enderror

                                <!-- State ---------------------------------------------------------------------------->

                                <x-aaran-ui::dropdown.wrapper label="State" type="stateTyped">
                                    <div class="relative ">
                                        <x-aaran-ui::dropdown.input label="State" id="state_name"
                                                          wire:model.live="state_name"
                                                          wire:keydown.arrow-up="decrementState"
                                                          wire:keydown.arrow-down="incrementState"
                                                          wire:keydown.enter="enterState"/>
                                        <x-aaran-ui::dropdown.select>
                                            @if($stateCollection)
                                                @forelse ($stateCollection as $i => $states)
                                                    <x-aaran-ui::dropdown.option highlight="{{$highlightState === $i  }}"
                                                                       wire:click.prevent="setState('{{$states->vname}}','{{$states->id}}')">
                                                        {{ $states->vname }}
                                                    </x-aaran-ui::dropdown.option>
                                                @empty
                                                    <x-aaran-ui::dropdown.create wire:click.prevent="stateSave('{{ $state_name }}')" label="State" />
                                                @endforelse
                                            @endif
                                        </x-aaran-ui::dropdown.select>
                                    </div>
                                </x-aaran-ui::dropdown.wrapper>

                                @error('state_name')
                                <span class="text-red-400 text-xs">{{$message}}</span>
                                @enderror
                                <!-- Pin-code ------------------------------------------------------------------------->

                                <x-aaran-ui::dropdown.wrapper label="Pincode" type="pincodeTyped">
                                    <div class="relative ">
                                        <x-aaran-ui::dropdown.input label="Pincode" id="pincode_name"
                                                          wire:model.live="pincode_name"
                                                          wire:keydown.arrow-up="decrementPincode"
                                                          wire:keydown.arrow-down="incrementPincode"
                                                          wire:keydown.enter="enterPincode"/>
                                        <x-aaran-ui::dropdown.select>
                                            @if($pincodeCollection)
                                                @forelse ($pincodeCollection as $i => $pincode)
                                                    <x-aaran-ui::dropdown.option highlight="{{$highlightPincode === $i  }}"
                                                                       wire:click.prevent="setPincode('{{$pincode->vname}}','{{$pincode->id}}')">
                                                        {{ $pincode->vname }}
                                                    </x-aaran-ui::dropdown.option>
                                                @empty
                                                    <x-aaran-ui::dropdown.create wire:click.prevent="pincodeSave('{{$pincode_name}}')" label="Pincode" />
                                                @endforelse
                                            @endif
                                        </x-aaran-ui::dropdown.select>
                                    </div>
                                </x-aaran-ui::dropdown.wrapper>
                                @error('pincode_name')
                                <span class="text-red-400 text-xs">{{$message}}</span>
                                @enderror

                                <!-- country ------------------------------------------------------------------------->
                                <x-aaran-ui::dropdown.wrapper label="Country" type="countryTyped">
                                    <div class="relative">
                                        <x-aaran-ui::dropdown.input label="Country" id="country_name"
                                                          wire:model.live="country_name"
                                                          wire:keydown.arrow-up="decrementCountry"
                                                          wire:keydown.arrow-down="incrementCountry"
                                                          wire:keydown.enter="enterCountry"/>
                                        <x-aaran-ui::dropdown.select>
                                            @if($countryCollection)
                                                @forelse ($countryCollection as $i => $country)
                                                    <x-aaran-ui::dropdown.option highlight="{{$highlightCountry === $i}}"
                                                                       wire:click.prevent="setCountry('{{$country->vname}}','{{$country->id}}')">
                                                        {{ $country->vname }}
                                                    </x-aaran-ui::dropdown.option>
                                                @empty
                                                    <x-aaran-ui::dropdown.create wire:click.prevent="countrySave('{{$country_name}}')" label="Country" />
                                                @endforelse
                                            @endif
                                        </x-aaran-ui::dropdown.select>
                                    </div>
                                </x-aaran-ui::dropdown.wrapper>
                                @error('country_name')
                                <span class="text-red-400 text-xs">{{$message}}</span>
                                @enderror
                            </div>
                        </x-aaran-ui::tabs.content>

                        <!-- Tab 3 ------------------------------------------------------------------------------------>

                        <x-aaran-ui::tabs.content>
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
                                                <x-aaran-ui::icons.icon :icon="'logo'" class="w-auto h-auto block "/>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <div>
                                            <label for="bg_image"
                                                   class="text-gray-500 font-semibold text-base rounded flex flex-col items-center
                                   justify-center cursor-pointer border-2 border-gray-300 border-dashed p-2
                                   mx-auto font-[sans-serif]">
                                                <x-aaran-ui::icons.icon icon="cloud-upload" class="w-8 h-auto block text-gray-400"/>
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

                        </x-aaran-ui::tabs.content>

                        <!-- Tab 4 ------------------------------------------------------------------------------------>

                        <x-aaran-ui::tabs.content>
                            <div class="flex flex-col gap-3">

                                <!-- Bank Details --------------------------------------------------------------------->

                                <x-aaran-ui::input.floating wire:model="acc_no" label="Account No" />
                                <x-aaran-ui::input.floating wire:model="ifsc_code" label="IFSC Code" />
                                <x-aaran-ui::input.floating wire:model="bank" label="Bank" />
                                <x-aaran-ui::input.floating wire:model="branch" label="Branch" />
                                <x-aaran-ui::input.floating wire:model.live="inv_pfx" label="Invoice Prefix"/>
                                <x-aaran-ui::input.floating wire:model.live="iec_no" label="IEC No"/>
                            </div>
                        </x-aaran-ui::tabs.content>

                        <!-- Tab 5 ------------------------------------------------------------------------------------>

                        <x-aaran-ui::tabs.content>

                            <div class="flex flex-col gap-3">
                                <x-aaran-ui::input.floating wire:model="msme_no" label="MSME No" />

                                <x-aaran-ui::dropdown.wrapper label="MSME Type" type="MsmeTypeTyped">
                                    <div class="relative ">
                                        <x-aaran-ui::dropdown.input label="MSME Type" id="msme_type_name"
                                                          wire:model.live="msme_type_name"
                                                          wire:keydown.arrow-up="decrementMsmeType"
                                                          wire:keydown.arrow-down="incrementMsmeType"
                                                          wire:keydown.enter="enterMsmeType"/>

                                        <x-aaran-ui::dropdown.select wire:model="msme_type_id">
                                            @if($msmeTypeCollection)
                                                @foreach ($msmeTypeCollection as $msmeType)
                                                    <x-aaran-ui::dropdown.option
                                                        :highlight="$highlightMsmeType === $loop->index"
                                                        wire:click.prevent="setMsmeType('{{ $msmeType['id'] }}')">
                                                        {{ $msmeType['vname'] }}
                                                    </x-aaran-ui::dropdown.option>
                                                @endforeach
                                            @endif
                                        </x-aaran-ui::dropdown.select>

                                    </div>
                                </x-aaran-ui::dropdown.wrapper>

{{--                                <x-aaran-ui::input.floating wire:model="msme_type" label="MSME Type" />--}}
                            </div>
                        </x-aaran-ui::tabs.content>
                    </x-slot>
                </x-aaran-ui::tabs.tab-panel>
            </div>
        </x-aaran-ui::forms.create>

        <!-- Actions ------------------------------------------------------------------------------------------->

    </x-aaran-ui::forms.m-panel>

</div>
