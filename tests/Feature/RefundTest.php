<?php

declare(strict_types=1);

use RKocak\Vallet\Exceptions\{InvalidArgumentException, RequestFailedException};
use RKocak\Vallet\Facades\Vallet;
use RKocak\Vallet\RefundResponse;

it('requires valletOrderId to be set', function () {
    $refund = Vallet::createRefund();
    $refund->setAmount(100)
        ->setOrderId('11111');

    $refund->process();
})->throws(InvalidArgumentException::class);

it('requires orderId to be set', function () {
    $refund = Vallet::createRefund();
    $refund->setAmount(100)
        ->setValletOrderId(1111);

    $refund->process();
})->throws(InvalidArgumentException::class);

it('requires amount to be set', function () {
    $refund = Vallet::createRefund();
    $refund->setValletOrderId(1111)
        ->setOrderId('11111');

    $refund->process();
})->throws(InvalidArgumentException::class);

it('returns RefundResponse', function () {
    $refund = Vallet::createRefund();
    $refund->setAmount(100)
        ->setOrderId('11111')
        ->setValletOrderId(1111);

    $response = $refund->process();

    expect($response)->toBeInstanceOf(RefundResponse::class);
});

it('returns RefundResponse with success status', function () {
    forceValletRefundRequest();

    $refund = Vallet::createRefund();
    $refund->setAmount(100)
        ->setOrderId('11111')
        ->setValletOrderId(1111);

    $response = $refund->process();

    expect($response->success())->toBeTrue()
        ->and($response->failed())->toBeFalse();
});

it('returns RefundResponse with failed status', function () {
    forceValletRefundRequest('error');

    $refund = Vallet::createRefund();
    $refund->setAmount(100)
        ->setOrderId('11111')
        ->setValletOrderId(1111);

    $response = $refund->process();

    expect($response->success())->toBeFalse()
        ->and($response->failed())->toBeTrue();
});

it('throws error if the request fails (Vallet server is down)', function () {
    forceValletRefundRequest(
        'error',
        'An error occurred.',
        httpStatus: 500
    );

    $refund = Vallet::createRefund();
    $refund->setAmount(100)
        ->setOrderId('11111')
        ->setValletOrderId(1111);

    $refund->process();
})->throws(RequestFailedException::class);

it('returns refund id', function () {
    forceValletRefundRequest(
        extraData: [
            'refundId' => 12345,
        ]
    );

    $refund = Vallet::createRefund();
    $refund->setAmount(100)
        ->setOrderId('11111')
        ->setValletOrderId(1111);

    $response = $refund->process();

    expect($response->getRefundId())->toBe(12345);
});
