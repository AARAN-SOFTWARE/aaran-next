<div>

    <x-slot name="header">Icons</x-slot>

    <x-Ui::forms.m-panel>

{{--        <----row-1----->--}}
        <x-Ui::icons.search-new/>

        <div class="bg-white">
            <div class="lg:grid lg:grid-cols-12 gap-2 md:grid md:grid-cols-8">
                @foreach($list as $row)
                    <x-Ui::icons.utilities :icon="$row"/>
                @endforeach

            </div>
        </div>

        <div class="border-b-2 border-amber-900">&nbsp;</div>

        <div class="bg-white">
            <div class="lg:grid lg:grid-cols-12 gap-2 md:grid md:grid-cols-8">
                @foreach($fill as $row)
                    <x-Ui::icons.utilities-fill :icon="$row" :colour="'#E90074'"/>
                @endforeach
            </div>
        </div>
    </x-Ui::forms.m-panel>
</div>


