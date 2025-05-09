@props([
    'showFilters'=>false,
    'contacts',
    'orders'
])

<div>
    @if ($showFilters)
        <div class="bg-zinc-200 p-4 rounded shadow-inner flex relative">
            <div class="flex justify-between w-full ">
                @if($orders!="")
                    <div class="ml-3">
                        <x-Ui::input.model-select wire:model.live="byOrder" :label="'Order No'">
                            <option value="">choose</option>
                            @foreach($orders as $i)
                                <option value="{{$i->id}}">{{$i->vname}}</option>
                            @endforeach
                        </x-Ui::input.model-select>
                    </div>
                @endif
                @if($contacts!="")
                    <div class="ml-3">
                        <x-Ui::input.model-select wire:model.live="filter" :label="'Party Name'">
                            <option value="">choose</option>
                            @foreach($contacts as $i)
                                <option value="{{$i->id}}">{{$i->vname}}</option>
                            @endforeach
                        </x-Ui::input.model-select>
                    </div>
                @endif
                    <div class="ml-3">
                        {{$slot}}
                    </div>

                <div class="ml-3">
                    <x-Ui::input.model-date wire:model.live="start_date" :label="'From'"/>
                </div>
                <div class="ml-3">
                    <x-Ui::input.model-date wire:model.live="end_date" :label="'To'"/>
                </div>
            </div>
            <div class="w-1/4 pl-2 space-y-4">
                <x-Ui::button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">Reset
                    Filters
                </x-Ui::button.link>
            </div>
        </div>
    @endif
</div>
