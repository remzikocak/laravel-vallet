<?php

declare(strict_types=1);

use RKocak\Vallet\Enums\{Currency, Locale, ProductType};
use RKocak\Vallet\Exceptions\{CurrencyNotSetException,
    InvalidArgumentException,
    LocaleNotSetException,
    RequestFailedException};
use RKocak\Vallet\Facades\Vallet;
use RKocak\Vallet\Product;

$methodNames = [
    'setConversationId' => '123456789',
    'setOrderId'        => '123456789',
    'setProductName'    => 'Test Product',
    'setTotalPrice'     => 100,
    'setOrderPrice'     => 100,
];

it('can create payment url', function () {
    forceValletResponse();

    $payment = Vallet::createPayment();
    $payment->setBuyer(getBuyer())
        ->setLocale(Locale::Turkish)
        ->setCurrency(Currency::Try)
        ->setConversationId('123456789')
        ->setOrderId('123456789')
        ->setProductName('Test Product')
        ->setTotalPrice(100)
        ->setOrderPrice(100);

    $payment->addProduct(
        Product::make()
            ->setName('Test Product')
            ->setPrice(13.50)
            ->setType(ProductType::Digital)
    );

    $link = $payment->getLink();

    expect($link)->toBe('https://www.vallet.com.tr/fake-payment-page-url');
});

it('throws error if no product is added', function () {
    forceValletResponse();

    $payment = Vallet::createPayment();
    $payment->setBuyer(getBuyer())
        ->setLocale(Locale::Turkish)
        ->setCurrency(Currency::Try)
        ->setConversationId('123456789')
        ->setOrderId('123456789')
        ->setProductName('Test Product')
        ->setTotalPrice(100)
        ->setOrderPrice(100);

    $payment->getLink();
})->throws(InvalidArgumentException::class);

it('throws error if required field is not set', function (string $skipMethod) {
    global $methodNames;

    forceValletResponse();

    $payment = Vallet::createPayment();
    $payment->setBuyer(getBuyer())
        ->setLocale(Locale::Turkish)
        ->setCurrency(Currency::Try);

    foreach ($methodNames as $methodName => $methodArg) {
        if ($methodName === $skipMethod) {
            continue;
        }

        $payment->{$methodName}($methodArg);
    }

    $payment->getLink();
})->with(array_keys($methodNames))->throws(InvalidArgumentException::class);

it('requires valid locale to be set', function () {
    forceValletResponse();

    $payment = Vallet::createPayment();
    $payment->setBuyer(getBuyer())
        ->setCurrency(Currency::Try)
        ->setConversationId('123456789')
        ->setOrderId('123456789')
        ->setProductName('Test Product')
        ->setTotalPrice(100)
        ->setOrderPrice(100)
        ->addProduct(
            Product::make()
                ->setName('Test Product')
                ->setPrice(13.50)
                ->setType(ProductType::Digital)
        );

    $payment->getLink();
})->throws(LocaleNotSetException::class);

it('requires valid currency to be set', function () {
    forceValletResponse();

    $payment = Vallet::createPayment();
    $payment->setBuyer(getBuyer())
        ->setLocale(Locale::Turkish)
        ->setConversationId('123456789')
        ->setOrderId('123456789')
        ->setProductName('Test Product')
        ->setTotalPrice(100)
        ->setOrderPrice(100)
        ->addProduct(
            Product::make()
                ->setName('Test Product')
                ->setPrice(13.50)
                ->setType(ProductType::Digital)
        );

    $payment->getLink();
})->throws(CurrencyNotSetException::class);

it('throws exception if Vallet server is down', function () {
    forceValletResponse(
        status: 'error',
        message: 'Vallet Server is down.',
        httpStatus: 500
    );

    $payment = Vallet::createPayment();
    $payment->setBuyer(getBuyer())
        ->setLocale(Locale::Turkish)
        ->setCurrency(Currency::Try)
        ->setConversationId('123456789')
        ->setOrderId('123456789')
        ->setProductName('Test Product')
        ->setTotalPrice(100)
        ->setOrderPrice(100)
        ->setProductType(ProductType::Digital)
        ->addProduct(
            Product::make()
                ->setName('Test Product')
                ->setPrice(13.50)
                ->setType(ProductType::Digital)
        );

    $payment->getLink();
})->throws(RequestFailedException::class);

it('throws exception if Vallet returns error status', function () {
    forceValletResponse(
        status: 'error',
        message: 'Vallet Server is down.',
    );

    $payment = Vallet::createPayment();
    $payment->setBuyer(getBuyer())
        ->setLocale(Locale::Turkish)
        ->setCurrency(Currency::Try)
        ->setConversationId('123456789')
        ->setOrderId('123456789')
        ->setProductName('Test Product')
        ->setTotalPrice(100)
        ->setOrderPrice(100)
        ->addProduct(
            Product::make()
                ->setName('Test Product')
                ->setPrice(13.50)
                ->setType(ProductType::Digital)
        );

    $payment->getLink();
})->throws(RequestFailedException::class);
