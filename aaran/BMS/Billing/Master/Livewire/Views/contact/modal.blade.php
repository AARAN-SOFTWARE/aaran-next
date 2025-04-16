<div x-data="{ showCreateModal: @entangle('showCreateModal')}">
    <div
        x-show="showCreateModal"
        @click.away="showCreateModal = false"
        x-cloak
        x-on:close.stop="showCreateModal = false"
        x-on:keydown.escape.window="showCreateModal = false"
        x-trap.inert.noscroll="showCreateModal"
        class="absolute z-20">

        <div class="relative" role="dialog">

            <div class="fixed inset-0 bg-gray-800/75"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div
                    class="flex min-h-full justify-center items-center">
                    <div class="relative sm:w-full sm:max-w-4xl sm:mx-auto">

                        <div class="bg-white rounded-t-lg px-4 pb-4">

                            <div class="text-lg text-neutral-300 py-3 left-2">Create New</div>

                            <x-Ui::tabs.tab-panel>

                                <x-slot name="tabs">
                                    <x-Ui::tabs.tab>Mandatory</x-Ui::tabs.tab>
                                    <x-Ui::tabs.tab>Address</x-Ui::tabs.tab>
                                    <x-Ui::tabs.tab>Bank</x-Ui::tabs.tab>
                                    <x-Ui::tabs.tab>Detailing</x-Ui::tabs.tab>
                                </x-slot>

                                <x-slot name="content">

                                    <!-- Tab 1 ------------------------------------------------------------------------------------>

                                    <x-Ui::tabs.content>
                                        <div class="flex flex-col gap-3">

                                            <div>
                                                <x-Ui::input.floating autofocus
                                                                      wire:model.defer="vname" label="Name"/>
                                                <x-Ui::input.error-text wire:model="vname"/>
                                            </div>

                                            <x-Ui::input.floating wire:model="mobile" label="Mobile"/>
                                            <x-Ui::input.floating wire:model="whatsapp" label="Whatsapp"/>
                                            <x-Ui::input.floating wire:model="contact_person" label="Contact person"/>

                                            <div>
                                                <x-Ui::input.floating wire:model.live="gstin" label="GSTin"/>
                                                <x-Ui::input.error-text wire:model="gstin"/>
                                            </div>

                                            <x-Ui::input.floating wire:model="email" label="Email"/>

                                            <x-Ui::dropdown.wrapper label="Contact Type" type="contactTypeTyped">
                                                <div class="relative ">
                                                    <x-Ui::dropdown.input label="Contact Type" id="contact_type_name"
                                                                          wire:model.live="contact_type_name"
                                                                          wire:keydown.arrow-up="decrementContactType"
                                                                          wire:keydown.arrow-down="incrementContactType"
                                                                          wire:keydown.enter="enterContactType"
                                                    />
                                                    <x-Ui::dropdown.select>
                                                        @if($contactTypeCollection)
                                                            @forelse ($contactTypeCollection as $i => $contactType)
                                                                <x-Ui::dropdown.option
                                                                    highlight="{{$highlightContactType === $i  }}"
                                                                    wire:click.prevent="setContactType('{{$contactType->vname}}','{{$contactType->id}}')">
                                                                    {{ $contactType->vname }}
                                                                </x-Ui::dropdown.option>
                                                            @empty
                                                                <x-Ui::dropdown.create
                                                                    wire:click.prevent="contactTypeSave('{{$contact_type_name}}')"
                                                                    label="Contact Type"/>
                                                            @endforelse
                                                        @endif
                                                    </x-Ui::dropdown.select>
                                                </div>

                                                <x-Ui::input.error-text wire:model="contact_type_name"/>

                                            </x-Ui::dropdown.wrapper>

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
                                                                <x-Ui::dropdown.option
                                                                    highlight="{{$highlightCity === $i  }}"
                                                                    wire:click.prevent="setCity('{{$city->vname}}','{{$city->id}}')">
                                                                    {{ $city->vname }}
                                                                </x-Ui::dropdown.option>
                                                            @empty
                                                                <x-Ui::dropdown.create
                                                                    wire:click.prevent="citySave('{{$city_name}}')"
                                                                    label="City"/>
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
                                                                <x-Ui::dropdown.option
                                                                    highlight="{{$highlightState === $i  }}"
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
                                                                <x-Ui::dropdown.option
                                                                    highlight="{{$highlightPincode === $i  }}"
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
                                                                <x-Ui::dropdown.option
                                                                    highlight="{{$highlightCountry === $i}}"
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

                                    <!-- Tab 4 ------------------------------------------------------------------------------------>

                                    <x-Ui::tabs.content>
                                        <div class="flex flex-col gap-3">

                                            <!-- Bank Details --------------------------------------------------------------------->

                                            <x-Ui::input.floating wire:model="acc_no" label="Account No"/>
                                            <x-Ui::input.floating wire:model="ifsc_code" label="IFSC Code"/>
                                            <x-Ui::input.floating wire:model="bank" label="Bank"/>
                                            <x-Ui::input.floating wire:model="branch" label="Branch"/>
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

                                            <x-Ui::input.floating wire:model="opening_balance" label="Opening balance"/>

                                            <x-Ui::input.floating wire:model="outstanding" label="Outstanding"/>

                                            <x-Ui::input.floating wire:model="effective_from" label="Effective from"/>

                                        </div>
                                    </x-Ui::tabs.content>
                                </x-slot>

                            </x-Ui::tabs.tab-panel>

                        </div>

                        <div class="bg-gray-100  rounded-b-lg px-4 py-3 flex gap-3 justify-end">

                            <x-Ui::button.back-x @click="showCreateModal = false"/>

                            <x-Ui::button.save-x wire:click.prevent="save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
