<?php

declare(strict_types=1);

namespace RKocak\Vallet;

use Illuminate\Support\ServiceProvider;
use RKocak\Vallet\Contracts\PaymentContract;

class ValletServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentContract::class, function ($app) {

        });
    }

    public function provides(): array
    {
        return [
            PaymentContract::class,
        ];
    }
}
