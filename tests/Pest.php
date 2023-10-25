<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use RKocak\Vallet\Payment;
use RKocak\Vallet\Tests\TestCase;

uses(TestCase::class)->in(__DIR__.'/Feature');

function forceValletResponse(string $message = 'An error occurred', int $status = 500): void
{
    Http::fake([
        Payment::VALLET_URL => Http::response([
            'status'           => 'error',
            'errorMessage'     => $message,
            'payment_page_url' => 'https://www.vallet.com.tr/fake-payment-page-url',
        ], $status),
    ]);
}
