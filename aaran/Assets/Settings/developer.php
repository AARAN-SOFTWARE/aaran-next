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
//        Customise::exportSales(),
        Customise::report(),
        Customise::logbooks(),
        Customise::books(),
    ],

    'SalesEntry' => [
        SaleEntry::job_no(),
        SaleEntry::bundle(),
        SaleEntry::dc_no(),
        SaleEntry::po_no(),
        SaleEntry::no_of_roll(),
        SaleEntry::order(),
        SaleEntry::order(),
        SaleEntry::billingAddress(),
        SaleEntry::shippingAddress(),
        SaleEntry::style(),
//        SaleEntry::despatch(),
        SaleEntry::transport(),
        SaleEntry::destination(),
        SaleEntry::bundle(),
//        SaleEntry::einvoice(),
//        SaleEntry::eway(),

        SaleEntry::productDescription(),
        SaleEntry::colour(),
        SaleEntry::size(),

    ],
];
