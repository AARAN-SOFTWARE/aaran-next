@if(Aaran\Assets\Features\Customise::hasCommon())
    <x-Ui::menu.app.base.li-menuitem :routes="'sales'" :label="'Sales'"/>
@endif

{{--@if(Aaran\Assets\Features\Customise::hasExportSales())--}}
{{--<x-Ui::menu.app.base.li-menuitem :routes="'exportsales'" :label="'Export Sales'"/>--}}
{{--@endif--}}

{{--@if(Aaran\Assets\Features\Customise::hasEntries())--}}
{{--<x-Ui::menu.app.base.li-menuitem :routes="'purchase'" :label="'Purchase'"/>--}}
{{--@endif--}}

{{--<x-Ui::menu.app.base.route-menuitem  href="{{route('transactions',[1])}}" :label="'Payment'"/>--}}

{{--<x-Ui::menu.app.base.route-menuitem  href="{{route('transactions',[2])}}" :label="'Receipt'"/>--}}


