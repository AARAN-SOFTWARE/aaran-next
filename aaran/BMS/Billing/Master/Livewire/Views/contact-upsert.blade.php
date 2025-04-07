<div>
    <x-slot name="header">Contact Entry</x-slot>

    <!-- Top Controls ------------------------------------------------------------------------------------------------>

    <x-Ui::forms.m-panel-auto>

        <x-Ui::alerts.notification/>

        <x-Ui::tabs.tab-panel>

            <x-slot name="tabs">
                <x-Ui::tabs.tab>Mandatory</x-Ui::tabs.tab>
                <x-Ui::tabs.tab>Detailing</x-Ui::tabs.tab>
            </x-slot>

            <x-slot name="content">

                <x-Ui::tabs.content>

                    <div class="lg:flex-row flex flex-col sm:gap-8 gap-4">

                        <!-- Left area -------------------------------------------------------------------------------->

                        <div class="sm:w-1/2 w-full flex flex-col gap-3 ">

                            <div>
                                <x-Ui::input.floating wire:model.live="vname" label="Contact Name"/>
                                <x-Ui::input.error-text wire:model="vname"/>
                            </div>

                            <div>
                                <x-Ui::input.floating wire:model="mobile" label="Mobile"/>
                                <x-Ui::input.error-text wire:model="mobile"/>
                            </div>
                            <x-Ui::input.floating wire:model="whatsapp" label="Whatsapp"/>
                            <x-Ui::input.floating wire:model="contact_person" label="Contact Person"/>

                            <div>
                                <x-Ui::input.floating wire:model.live="gstin" label="GST No"/>
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
                                                <x-Ui::dropdown.option highlight="{{$highlightContactType === $i  }}"
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

                        <!-- Right area ------------------------------------------------------------------------------->

                        <div class="lg:w-1/2 flex flex-col gap-3">
                            <div
                                x-data="{
                                        openTab: @entangle('openTab').defer,
                                        activeClasses: 'border-l border-t border-r rounded-t text-blue-700 cursor-pointer',
                                        inactiveClasses: 'text-gray-400 hover:text-blue-700',
                                        init() {
                                            if (this.openTab === null || this.openTab === undefined) {
                                                this.openTab = 0;
                                            }

                                            this.$watch('openTab', value => {
                                                this.$nextTick(() => {
                                                    this.$refs['tab_' + value]?.scrollIntoView({ behavior: 'smooth', inline: 'center' });
                                                });
                                            });
                                        }
                                    }"
                                class="space-y-1"
                            >

                                {{-- Tabs --}}
                                <ul class="flex flex-wrap border-b items-center overflow-x-auto space-x-2">

                                    {{-- Primary Tab --}}
                                    <li x-ref="tab_0" @click="openTab = 0" :class="{ '-mb-px': openTab === 0 }">
                                        <a href="#"
                                           @click.prevent="$wire.sortSearch(0)"
                                           :class="openTab === 0 ? activeClasses : inactiveClasses"
                                           class="bg-white inline-block py-3 px-4 font-semibold">
                                            Primary
                                        </a>
                                    </li>

                                    {{-- Dynamic Secondary Tabs --}}
                                    @foreach($secondaryAddress as $index => $row)
                                        <li x-ref="tab_{{ $row }}" @click="openTab = {{ $row }}"
                                            :class="{ '-mb-px': openTab === {{ $row }} }" class="mr-1">
                                            <div class="inline-flex items-center gap-2 py-2 px-4"
                                                 :class="openTab === {{ $row }} ? activeClasses : inactiveClasses">
                                                <a href="#" @click.prevent="$wire.sortSearch({{ $row }})"
                                                   class="bg-white inline-block font-semibold">
                                                    <span>Address - {{ $row + 1 }}</span>
                                                </a>
                                                <button @click.prevent="openTab = {{ $row - 1 }}"
                                                        wire:click="removeAddress({{ $index }}, {{ $row }})"
                                                        class="hover:text-red-400 pt-1">
                                                    <x-Ui::icons.icon icon="x-mark" class="block h-3 w-3"/>
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach

                                    {{-- Add Address Button --}}
                                    <li class="mr-1">
                                        <button
                                            x-bind:disabled="{{ count($itemList) }} >= 4"
                                            :class="({{ count($itemList) }} >= 4) ? 'opacity-50 cursor-not-allowed' : inactiveClasses"
                                            class="inline-block py-2 px-4 font-semibold bg-neutral-700 text-white hover:text-yellow-500 cursor-pointer"
                                            wire:click="addAddress('{{ $addressIncrement }}')"
                                        >
                                            + Add
                                        </button>
                                    </li>

                                </ul>

                                {{-- Tab Content --}}
                                <div class="w-full">

                                    {{-- Primary Address --}}
                                    <div x-show="openTab === 0" x-cloak x-transition.opacity x-transition.duration.300ms
                                         class="py-2">
                                        <h3 class="text-xs text-gray-300">Primary Address</h3>
                                        <div class="flex flex-col gap-3 mt-2">
                                            <x-Ui::input.floating wire:model.live="itemList.0.address_1"
                                                                  label="Address"/>
                                            <x-Ui::input.floating wire:model.live="itemList.0.address_2"
                                                                  label="Area-Road"/>
                                        </div>
                                    </div>

                                    {{-- Secondary Address Tabs --}}
                                    @foreach($secondaryAddress as $index => $row)
                                        <div x-show="openTab === {{ $row }}" x-cloak x-transition.opacity
                                             x-transition.duration.300ms class="py-2">
                                            <h3 class="text-xs text-gray-400">Address - {{ $row + 1 }}</h3>
                                            <div class="flex flex-col gap-3 mt-2">
                                                <x-Ui::input.floating wire:model.live="itemList.{{ $row }}.address_1"
                                                                      label="Address"/>
                                                <x-Ui::input.floating wire:model.live="itemList.{{ $row }}.address_2"
                                                                      label="Area-Road"/>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>


                    </div>

                </x-Ui::tabs.content>

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

                        <x-Ui::input.floating wire:model="opening_balance" label="Opening Balance"/>

                        {{--                        <x-input.floating wire:model="outstanding" label="Outstanding"/>--}}

                        <x-Ui::input.model-date wire:model="effective_from" :label="'Opening Date'"/>
                    </div>
                </x-Ui::tabs.content>

            </x-slot>
        </x-Ui::tabs.tab-panel>
    </x-Ui::forms.m-panel-auto>

    <!-- Save Button area --------------------------------------------------------------------------------------------->
    <x-Ui::forms.m-panel-bottom-button active save back/>

    <div class="px-10 py-16 space-y-4">
        {{--        @if(!$log->isEmpty())--}}
        {{--            <div class="text-xs text-orange-600  font-merri underline underline-offset-4">Activity</div>--}}
        {{--        @endif--}}
        {{--        @foreach($log as $row)--}}
        {{--            <div class="px-6">--}}
        {{--                <div class="relative">--}}
        {{--                    <div class=" border-l-[3px] border-dotted px-8 text-[10px]  tracking-wider py-3">--}}
        {{--                        <div class="flex gap-x-5 ">--}}
        {{--                            <div class="inline-flex text-gray-500 items-center font-sans font-semibold">--}}
        {{--                                <span>Model:</span> <span>{{$row->vname}}</span></div>--}}
        {{--                            <div class="inline-flex  items-center space-x-1 font-merri"><span--}}
        {{--                                    class="text-blue-600">@</span><span--}}
        {{--                                    class="text-gray-500">{{$row->user->name}}</span>--}}
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
    </div>
</div>
