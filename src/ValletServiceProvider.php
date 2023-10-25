<?php

declare(strict_types=1);

namespace RKocak\Vallet;

use Illuminate\Support\ServiceProvider;
use RKocak\Vallet\Contracts\{PaymentContract, ValletContract};

class ValletServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bindIf(ValletContract::class, function ($app) {
            return new Vallet($app['config']);
        });

        $this->publishes([
            __DIR__.'/../config/vallet.php' => config_path('vallet.php'),
        ], 'config');
    }

    public function provides(): array
    {
        return [
            ValletContract::class,
        ];
    }
}
