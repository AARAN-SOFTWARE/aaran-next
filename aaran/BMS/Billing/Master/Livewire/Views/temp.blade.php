



<div class="lg:w-1/2 flex flex-col gap-3">

    <div x-data="{
                                    openTab: 0,
                                    activeClasses: 'border-l border-t border-r rounded-t text-blue-700',
                                    inactiveClasses: 'text-blue-500 hover:text-blue-700'
                                }" class="space-y-1">
        <ul class="flex items-center border-b overflow-x-scroll space-x-2">
            <li x-on:click="$wire.sortSearch('{{0}}')" @click="openTab = 0"
                :class="{ '-mb-px': openTab === 0 }" class="-mb-px">
                <a href="#" :class="openTab === 0 ? activeClasses : inactiveClasses"
                   class="bg-white inline-block py-3 px-4 font-semibold ">
                    Primary
                </a>
            </li>
            @foreach($secondaryAddress as $index => $row)
                <li @click="openTab = {{$row}}" :class="{ '-mb-px': openTab === {{$row}} }"
                    class="mr-1 ">
                    <!-- Set active class by using :class provided by Alpine -->
                    <div class="inline-flex gap-2 py-2 px-4"
                         :class="openTab === {{$row}} ? activeClasses : inactiveClasses">
                        <a href="#" x-on:click="$wire.sortSearch('{{$row}}')"
                           class="bg-white inline-block   font-semibold">
                            <span>Secondary</span>
                        </a>
                        <button class="hover:text-red-400 pt-1" @click="openTab = {{$row-1}}"
                                wire:click="removeAddress('{{$index}}','{{$row}}')">
                            <x-Ui::icons.icon :icon="'x-mark'" class="block h-4 w-4"/>
                        </button>
                    </div>
                </li>
            @endforeach
            <li class="mr-1">
                <button :class="inactiveClasses"
                        class="bg-white inline-block py-2 px-4 font-semibold"
                        wire:click="addAddress('{{$addressIncrement}}')">
                    + Add
                </button>
            </li>
        </ul>

        <div class="w-full">
            <div x-show="openTab === 0" class="py-2">
                <div class="flex flex-col gap-3">

                    <x-Ui::input.floating wire:model.live="itemList.{{0}}.address_1"
                                          label="Address"/>
                    @error('itemList.0.address_1')
                    <span class="text-red-400"> {{$message}}</span>
                    @enderror
                    <x-Ui::input.floating wire:model.live="itemList.{{0}}.address_2"
                                          label="Area-Road"/>
                    @error('itemList.0.address_2')
                    <span class="text-red-400">{{$message}}</span>
                    @enderror

                    <x-Ui::dropdown.wrapper label="City" type="cityTyped">
                        <div class="relative ">
                            <x-Ui::dropdown.input label="City" id="city_name"
                                                  wire:model.live="itemList.{{0}}.city_name"
                                                  wire:keydown.arrow-up="decrementCity"
                                                  wire:keydown.arrow-down="incrementCity"
                                                  wire:keydown.enter="enterCity({{0}})"/>
                            <x-Ui::dropdown.select>
                                @if($cityCollection)
                                    @forelse ($cityCollection as $i => $city)
                                        <x-Ui::dropdown.option
                                            highlight="{{$highlightCity === $i  }}"
                                            wire:click.prevent="setCity('{{$city->vname}}','{{$city->id}}','{{0}}')">
                                            {{ $city->vname }}
                                        </x-Ui::dropdown.option>
                                    @empty
                                        <x-Ui::dropdown.new
                                            wire:click.prevent="citySave('{{ $itemList[0]['city_name'] }}','{{0}}')"
                                            label="City"/>
                                    @endforelse
                                @endif
                            </x-Ui::dropdown.select>
                        </div>

                        <x-Ui::input.error-text wire:model="itemList.0.city_name"/>

                    </x-Ui::dropdown.wrapper>

                    <!-- State ------------------------------------------------------------------>
                    <x-Ui::dropdown.wrapper label="State" type="stateTyped">
                        <div class="relative ">
                            <x-Ui::dropdown.input label="State" id="state_name"
                                                  wire:model.live="itemList.{{0}}.state_name"
                                                  wire:keydown.arrow-up="decrementState"
                                                  wire:keydown.arrow-down="incrementState"
                                                  wire:keydown.enter="enterState({{0}})"/>
                            <x-Ui::dropdown.select>
                                @if($stateCollection)
                                    @forelse ($stateCollection as $i => $states)
                                        <x-Ui::dropdown.option
                                            highlight="{{$highlightState === $i  }}"
                                            wire:click.prevent="setState('{{$states->vname}}','{{$states->id}}','{{0}}')">
                                            {{ $states->vname }}
                                        </x-Ui::dropdown.option>
                                    @empty
                                        <x-Ui::dropdown.new
                                            wire:click.prevent="stateSave('{{ $itemList[0]['state_name'] }}','{{0}}')"
                                            label="State"/>
                                    @endforelse
                                @endif
                            </x-Ui::dropdown.select>
                        </div>

                        <x-Ui::input.error-text wire:model="itemList.0.state_name"/>

                    </x-Ui::dropdown.wrapper>

                    <!-- Pincode ------------------------------------------------------------------>

                    <x-Ui::dropdown.wrapper label="Pincode" type="pincodeTyped">
                        <div class="relative ">
                            <x-Ui::dropdown.input label="Pincode" id="pincode_name"
                                                  wire:model.live="itemList.{{0}}.pincode_name"
                                                  wire:keydown.arrow-up="decrementPincode"
                                                  wire:keydown.arrow-down="incrementPincode"
                                                  wire:keydown.enter="enterPincode({{0}})"/>
                            <x-Ui::dropdown.select>
                                @if($pincodeCollection)
                                    @forelse ($pincodeCollection as $i => $pincode)
                                        <x-Ui::dropdown.option
                                            highlight="{{$highlightPincode === $i  }}"
                                            wire:click.prevent="setPincode('{{$pincode->vname}}','{{$pincode->id}}','{{0}}')">
                                            {{ $pincode->vname }}
                                        </x-Ui::dropdown.option>
                                    @empty
                                        <x-Ui::dropdown.new
                                            wire:click.prevent="pincodeSave('{{$itemList[0]['pincode_name'] }}','{{0}}')"
                                            label="Pincode"/>
                                    @endforelse
                                @endif
                            </x-Ui::dropdown.select>
                        </div>

                        <x-Ui::input.error-text wire:model="itemList.0.pincode_name"/>

                    </x-Ui::dropdown.wrapper>

                    <!-- Country -------------------------------------------------------------------------->
                    <x-Ui::dropdown.wrapper label="Country" type="countryTyped">
                        <div class="relative ">
                            <x-Ui::dropdown.input label="Country" id="country_name"
                                                  wire:model.live="itemList.{{0}}.country_name"
                                                  wire:keydown.arrow-up="decrementCountry"
                                                  wire:keydown.arrow-down="incrementCountry"
                                                  wire:keydown.enter="enterCountry('{{0}}')"/>
                            <x-Ui::dropdown.select>
                                @if($countryCollection)
                                    @forelse ($countryCollection as $i => $country)
                                        <x-Ui::dropdown.option
                                            highlight="{{$highlightCountry === $i  }}"
                                            wire:click.prevent="setCountry('{{$country->vname}}','{{$country->id}}','{{0}}')">
                                            {{ $country->vname }}
                                        </x-Ui::dropdown.option>
                                    @empty
                                        <x-Ui::dropdown.new
                                            wire:click.prevent="countrySave('{{$itemList[0]['country_name']}}','{{0}}')"
                                            label="Country"/>
                                    @endforelse
                                @endif
                            </x-Ui::dropdown.select>
                        </div>

                        <x-Ui::input.error-text wire:model="itemList.0.country_name"/>

                    </x-Ui::dropdown.wrapper>
                </div>
            </div>

            @foreach( $secondaryAddress as $index => $row )
                <div x-show="openTab === {{$row}}" class="p-2">

                    <div class="flex flex-col gap-3">

                        <x-Ui::input.floating wire:model.live="itemList.{{$row}}.address_1"
                                              label="Address"/>
                        <x-Ui::input.floating wire:model.live="itemList.{{$row}}.address_2"
                                              label="Area-Road"/>

                        <x-Ui::dropdown.wrapper label="City" type="cityTyped">
                            <div class="relative ">
                                <x-Ui::dropdown.input label="City" id="city_name"
                                                      wire:model.live="itemList.{{$row}}.city_name"
                                                      wire:keydown.arrow-up="decrementCity"
                                                      wire:keydown.arrow-down="incrementCity"
                                                      wire:keydown.enter="enterCity('{{$row}}')"/>
                                <x-Ui::dropdown.select>
                                    @if($cityCollection)
                                        @forelse ($cityCollection as $i => $city)
                                            <x-Ui::dropdown.option
                                                highlight="{{$highlightCity === $i  }}"
                                                wire:click.prevent="setCity('{{$city->vname}}','{{$city->id}}','{{$row}}')">
                                                {{ $city->vname }}
                                            </x-Ui::dropdown.option>
                                        @empty
                                            <button
                                                wire:click.prevent="citySave('{{$itemList[$row]['city_name']}}','{{$row}}')"
                                                class="text-white bg-green-500 text-center w-full">
                                                create
                                            </button>
                                        @endforelse
                                    @endif
                                </x-Ui::dropdown.select>
                            </div>
                        </x-Ui::dropdown.wrapper>

                        <x-Ui::dropdown.wrapper label="State" type="stateTyped">
                            <div class="relative ">
                                <x-Ui::dropdown.input label="State" id="state_name"
                                                      wire:model.live="itemList.{{$row}}.state_name"
                                                      wire:keydown.arrow-up="decrementState"
                                                      wire:keydown.arrow-down="incrementState"
                                                      wire:keydown.enter="enterState('{{$row}}')"/>
                                <x-Ui::dropdown.select>
                                    @if($stateCollection)
                                        @forelse ($stateCollection as $i => $states)
                                            <x-Ui::dropdown.option
                                                highlight="{{$highlightState === $i  }}"
                                                wire:click.prevent="setState('{{$states->vname}}','{{$states->id}}','{{$row}}')">
                                                {{ $states->vname }}
                                            </x-Ui::dropdown.option>
                                        @empty
                                            <button
                                                wire:click.prevent="stateSave('{{$itemList[$row]['state_name']}}','{{$row}}')"
                                                class="text-white bg-green-500 text-center w-full">
                                                create
                                            </button>
                                        @endforelse
                                    @endif
                                </x-Ui::dropdown.select>
                            </div>
                        </x-Ui::dropdown.wrapper>

                        <x-Ui::dropdown.wrapper label="Pincode" type="pincodeTyped">
                            <div class="relative ">
                                <x-Ui::dropdown.input label="Pincode" id="pincode_name"
                                                      wire:model.live="itemList.{{$row}}.pincode_name"
                                                      wire:keydown.arrow-up="decrementPincode"
                                                      wire:keydown.arrow-down="incrementPincode"
                                                      wire:keydown.enter="enterPincode('{{$row}}')"/>
                                <x-Ui::dropdown.select>
                                    @if($pincodeCollection)
                                        @forelse ($pincodeCollection as $i => $pincode)
                                            <x-Ui::dropdown.option
                                                highlight="{{$highlightPincode === $i  }}"
                                                wire:click.prevent="setPincode('{{$pincode->vname}}','{{$pincode->id}}','{{$row}}')">
                                                {{ $pincode->vname }}
                                            </x-Ui::dropdown.option>
                                        @empty
                                            <button
                                                wire:click.prevent="pincodeSave('{{$itemList[$row]['pincode_name']}}','{{$row}}')"
                                                class="text-white bg-green-500 text-center w-full">
                                                create
                                            </button>
                                        @endforelse
                                    @endif
                                </x-Ui::dropdown.select>
                            </div>
                        </x-Ui::dropdown.wrapper>

                        <x-Ui::dropdown.wrapper label="Country" type="countryTyped">
                            <div class="relative ">

                                <x-Ui::dropdown.input label="Country" id="country_name"
                                                      wire:model.live="itemList.{{$row}}.country_name"
                                                      wire:keydown.arrow-up="decrementCountry"
                                                      wire:keydown.arrow-down="incrementCountry"
                                                      wire:keydown.enter="enterCountry('{{$row}}')"/>

                                <x-Ui::dropdown.select>
                                    @if($countryCollection)

                                        @forelse ($countryCollection as $i => $country)
                                            <x-Ui::dropdown.option
                                                highlight="{{$highlightCountry === $i  }}"
                                                wire:click.prevent="setCountry('{{$country->vname}}','{{$country->id}}','{{$row}}')">
                                                {{ $country->vname }}
                                            </x-Ui::dropdown.option>

                                        @empty

                                            <button
                                                wire:click.prevent="countrySave('{{$itemList[$row]['country_name']}}','{{$row}}')"
                                                class="text-white bg-green-500 text-center w-full">
                                                create
                                            </button>
                                        @endforelse
                                    @endif

                                </x-Ui::dropdown.select>
                            </div>
                        </x-Ui::dropdown.wrapper>

                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>


public function saveItems($contactId): void
{
if (empty($this->itemList)) {
// Save one default address if list is empty
ContactDetail::on($this->getTenantConnection())->create([
'contact_id' => $contactId,
'address_type' => 'Primary',
'address_1' => '-',
'address_2' => '-',
'city_id' => 1,
'state_id' => 1,
'pincode_id' => 1,
'country_id' => 1,
]);
return;
}

foreach ($this->itemList as $item) {

if (empty(trim($item->address_1 ?? ''))) {
continue; // Skip blank addresses
}

$data = [
'contact_id' => $contactId,
'address_type' => $item['address_type'] ?? 'Primary',
'address_1' => $item['address_1'] ?? '-',
'address_2' => $item['address_2'] ?? '-',
'city_id' => $this->isValidCity($item['city_id']) ? $item['city_id'] : 1,
'state_id' => $this->isValidState($item['state_id']) ? $item['state_id'] : 1,
'pincode_id' => $this->isValidPincode($item['pincode_id']) ? $item['pincode_id'] : 1,
'country_id' => $this->isValidCountry($item['country_id']) ? $item['country_id'] : 1,
];

if (empty($item['contact_detail_id']) || $item['contact_detail_id'] == 0) {
ContactDetail::on($this->getTenantConnection())->create($data);
} else {
$detail = ContactDetail::on($this->getTenantConnection())->find($item['contact_detail_id']);
if ($detail) {
$detail->update($data);
}
}
}
}

protected function isValidCity($id): bool
{
return City::on($this->getTenantConnection())->where('id', $id)->exists();
}

protected function isValidState($id): bool
{
return State::on($this->getTenantConnection())->where('id', $id)->exists();
}

protected function isValidPincode($id): bool
{
return Pincode::on($this->getTenantConnection())->where('id', $id)->exists();
}

protected function isValidCountry($id): bool
{
return Country::on($this->getTenantConnection())->where('id', $id)->exists();
}

