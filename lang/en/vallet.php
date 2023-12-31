<?php

declare(strict_types=1);

return [
    'paymentType' => [
        'KART'         => 'Credit/Debit Card',
        'BANKA_HAVALE' => 'Bank Transfer',
        'YURT_DISI'    => 'Foreign Credit/Debit Card',
    ],

    'currency' => [
        'usd' => 'US Dollar',
        'eur' => 'Euro',
        'try' => 'Turkish Lira',
    ],

    'locales' => [
        'turkish' => 'Turkish',
        'english' => 'English',
        'russian' => 'Russian',
        'german'  => 'German',
    ],

    'productType' => [
        'digital'  => 'Digital Product',
        'physical' => 'Physical Product',
    ],

    'productNameTooLong'    => 'Product name must be less or equal to 200 characters.',
    'credentialsNotSet'     => 'Username, password and shopCode must be set.',
    'callbackOkUrlNotSet'   => 'Callback ok URL must be set.',
    'callbackFailUrlNotSet' => 'Callback fail URL must be set.',
    'fieldNotSet'           => 'Field :field must be set.',
    'amountNotSet'          => 'Amount must be set.',
    'orderIdNotSet'         => 'Order ID must be set.',
    'requestFailed'         => 'Request failed.',
    'invalidEmail'          => 'Invalid email address.',
    'invalidIpAddress'      => 'Invalid IP address.',
    'invalidHash'           => 'Invalid hash.',
    'attrNotSet'            => 'Attribute :attr must be set.',
];
