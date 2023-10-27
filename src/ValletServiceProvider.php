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

        $this->mergeConfigFrom(__DIR__.'/../config/vallet.php', 'vallet');

        $this->publishes([
            __DIR__.'/../lang' => lang_path('vendor/vallet'),
        ], 'lang');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'vallet');
    }

    public function provides(): array
    {
        return [
            ValletContract::class,
        ];
    }
}
