<?php

return [
    'common' => [
        'custom_dashboard',
        'advanced_reports',
        'api_access',
    ],

    'general' => ['hasCommon', 'hasContact', 'hasSales', 'hasPurchase'],
    'contact' => ['hasGSTin', 'hasEway', 'hasMSME', 'hasSecondaryAddress', 'hasCreditLimit'],
    'sales' => ['hasDc', 'hasPO', 'hasStyle', 'hasColour'],
];

