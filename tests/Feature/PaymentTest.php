<?php

declare(strict_types=1);

use RKocak\Vallet\Enums\{Currency, Locale, ProductType};
use RKocak\Vallet\Facades\Vallet;
use RKocak\Vallet\Product;

it('can create payment url', function () {
    forceValletResponse();

    $payment = Vallet::createPayment();
    $payment->setBuyer(getBuyer())
        ->setLocale(Locale::Turkish)
        ->setCurrency(Currency::Try)
        ->setConversationId('123456789')
        ->setOrderId('123456789')
        ->setProductName('Test Product');

    $payment->addProduct(
        Product::make()
            ->setName('Test Product')
            ->setPrice(13.50)
            ->setType(ProductType::Digital)
    );

    $link = $payment->createLink();
});
