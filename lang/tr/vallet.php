<?php

declare(strict_types=1);

return [
    'paymentType' => [
        'KART'         => 'Kredi / Banka Kartı',
        'BANKA_HAVALE' => 'Havale / EFT',
        'YURT_DISI'    => 'Yurt Dışı Kredi Kartı',
    ],

    'productType' => [
        'digital'  => 'Dijital Ürün',
        'physical' => 'Fiziksel Ürün',
    ],

    'currency' => [
        'usd' => 'Amerikan Doları',
        'eur' => 'Euro',
        'try' => 'Türk Lirası',
    ],

    'locales' => [
        'turkish' => 'Türkçe',
        'english' => 'İngilizce',
        'russian' => 'Rusça',
        'german'  => 'Almanca',
    ],

    'productNameTooLong'    => 'Ürün adı 200 karakterden az veya eşit olmalıdır.',
    'credentialsNotSet'     => 'Kullanıcı adı, şifre ve mağaza kodu ayarlanmış olmalıdır.',
    'callbackOkUrlNotSet'   => 'Başarılı geri çağrı URL ayarlanmış olmalıdır.',
    'callbackFailUrlNotSet' => 'Başarısız geri çağrı URL ayarlanmış olmalıdır.',
    'fieldNotSet'           => 'Alan :field ayarlanmış olmalıdır.',
    'amountNotSet'          => 'Miktar ayarlanmış olmalıdır.',
    'orderIdNotSet'         => 'Sipariş ID ayarlanmış olmalıdır.',
    'requestFailed'         => 'İstek başarısız oldu.',
    'invalidEmail'          => 'Geçersiz e-posta adresi.',
    'invalidIpAddress'      => 'Geçersiz IP adresi.',
    'invalidHash'           => 'Geçersiz hash.',
    'attrNotSet'            => 'Özellik :attr ayarlanmış olmalıdır.',
];
