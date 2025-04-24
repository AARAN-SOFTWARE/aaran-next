@if(Aaran\Assets\Features\Customise::hasEntries())
    <x-Ui::menu.app.base.li-menuitem :routes="'sales'" :label="'Sales'"/>
    <x-Ui::menu.app.base.li-menuitem :routes="'purchases'" :label="'Purchase'"/>
@endif

<x-Ui::menu.app.base.route-menuitem  href="{{route('receipts')}}" :label="'Receipt'"/>
<x-Ui::menu.app.base.route-menuitem  href="{{route('payments')}}" :label="'Payment'"/>


