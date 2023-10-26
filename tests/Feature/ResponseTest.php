<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;
use RKocak\Vallet\Enums\{Currency, ProductType};
use RKocak\Vallet\Exceptions\{InvalidHashException, InvalidResponseException};
use RKocak\Vallet\Response;

function mergeRequestData(array $overrides = []): void
{
    request()->merge(array_merge([
        'status'             => 'success',
        'paymentStatus'      => 'paymentOk',
        'hash'               => 'DFd1UnljotylpQ76Sq9yQFMy8z0=',
        'paymentCurrency'    => Currency::Try->value,
        'paymentAmount'      => 100.00,
        'paymentType'        => 'BANKA_HAVALE',
        'paymentTime'        => '2023-01-01 00:00:00',
        'conversationId'     => '1234567890',
        'orderId'            => '1234567890',
        'shopCode'           => '123',
        'orderPrice'         => 100.00,
        'productsTotalPrice' => 100.00,
        'productType'        => ProductType::Digital->value,
        'callbackOkUrl'      => config('vallet.callbackUrl.ok'),
        'callbackFailUrl'    => config('vallet.callbackUrl.fail'),
        'valletOrderId'      => 1,
    ], $overrides));
}

it('throws exception if response field is missing', function (string $fieldName) {
    mergeRequestData([$fieldName => null]);

    $response = new Response();
    $response->validate();
})->throws(InvalidResponseException::class)->with([
    'status',
    'paymentStatus',
    'hash',
    'paymentCurrency',
    'paymentAmount',
    'paymentType',
    'paymentTime',
    'conversationId',
    'orderId',
    'shopCode',
    'orderPrice',
    'productsTotalPrice',
    'productType',
    'callbackOkUrl',
    'callbackFailUrl',
    'valletOrderId',
]);

it('throws exception if hash does not match', function () {
    mergeRequestData(['hash' => 'invalid-hash']);

    $response = new Response();
    $response->validate();
})->throws(InvalidHashException::class);

test('validation throws no exception if response is valid', function () {
    mergeRequestData();

    $response = new Response();
    $response->validate();

    expect($response->getOrderId())->toBe('1234567890')
        ->and($response->getCurrency())->toBe(Currency::Try)
        ->and($response->getProductsTotalPrice())->toBe(100.00)
        ->and($response->getProductType())->toBe(ProductType::Digital)
        ->and($response->getStatus())->toBe('paymentOk')
        ->and($response->getAmount())->toBe(100.00)
        ->and($response->getPaymentType())->toBe('BANKA_HAVALE')
        ->and($response->getPaymentTime())->toBeInstanceOf(Carbon::class)
        ->and($response->getConversationId())->toBe('1234567890')
        ->and($response->getCallbackOkUrl())->toBe(config('vallet.callbackUrl.ok'))
        ->and($response->getCallbackFailUrl())->toBe(config('vallet.callbackUrl.fail'));
});
