<?php

use Aaran\Assets\Features\Customise;
use Aaran\Assets\Features\SaleEntry;

return [

    'customise' => [
        Customise::common(),
        Customise::master(),
        Customise::entries(),
        Customise::core(),
        Customise::blog(),
        Customise::gstapi(),
        Customise::transaction(),
//        Customise::demodata(),
//        Customise::taskManager(),
        Customise::exportSales(),
        Customise::report(),
        Customise::logbooks(),
        Customise::books(),
    ],

    'SalesEntry' => [
        SaleEntry::order(),
        SaleEntry::billingAddress(),
        SaleEntry::shippingAddress(),
        SaleEntry::style(),
//        SaleEntry::despatch(),
        SaleEntry::transport(),
        SaleEntry::destination(),
        SaleEntry::bundle(),
        SaleEntry::einvoice(),
//        SaleEntry::eway(),

        SaleEntry::productDescription(),
        SaleEntry::colour(),
        SaleEntry::size(),

    ],
];
