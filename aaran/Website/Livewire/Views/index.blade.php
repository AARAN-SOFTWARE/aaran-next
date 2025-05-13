<div>
    <x-Ui::slider.new-2/>
    <x-Ui::web.home.cover-details/>
    {{--        <x-Ui::web.home.hero/>--}}
    {{--        <x-Ui::web.home-new.testimony />--}}
    {{--    <x-Ui::web.home-new.service/>--}}
    {{--    <x-Ui::web.home-new.features/>--}}
    {{--    <x-Ui::web.home.books :features="$features"/>--}}
    {{--    <x-Ui::web.home-new.partner />--}}

    <x-Ui::web.home.price :plan_features="$plans"/>
    <x-Ui::web.home.launch/>

    <x-Ui::web.home-new.footer />
    <x-Ui::web.home-new.copyright/>
</div>
