<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use RKocak\Vallet\Tests\TestCase;
use RKocak\Vallet\{Buyer, Payment, Refund};

uses(TestCase::class)->in(__DIR__.'/Feature');

function forceValletResponse(string $status = 'success', string $message = '', int $httpStatus = 200): void
{
    Http::fake([
        Payment::VALLET_URL.'*' => Http::response([
            'status'           => $status,
            'errorMessage'     => $message,
            'payment_page_url' => 'https://www.vallet.com.tr/fake-payment-page-url',
        ], $httpStatus),
    ]);
}

function forceValletRefundRequest(string $status = 'success', string $message = '', array $extraData = [], int $httpStatus = 200): void
{
    Http::fake([
        Refund::VALLET_REFUND_URL.'*' => Http::response([
            'status'       => $status,
            'errorMessage' => $message,
            'extraData'    => $extraData,
        ], $httpStatus),
    ]);
}

function getBuyer(): Buyer
{
    return (new Buyer())
        ->setName('Remzi')
        ->setSurname('Kocak')
        ->setEmail('hey@remzikocak.com')
        ->setCity('Istanbul')
        ->setCountry('Turkey')
        ->setDistrict('Atasehir')
        ->setPhoneNumber('5555555555')
        ->setAddress('Atasehir, Istanbul')
        ->setIp('127.0.0.1');
}
