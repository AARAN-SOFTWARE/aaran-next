<div>
    <x-Ui::lookup.modal-new>
        <x-Ui::tabs.tab-panel>

            <x-slot name="tabs">
                <x-Ui::tabs.tab>Address</x-Ui::tabs.tab>
            </x-slot>

            <x-slot name="content">

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

            </x-slot>

        </x-Ui::tabs.tab-panel>
    </x-Ui::lookup.modal-new>
</div>
