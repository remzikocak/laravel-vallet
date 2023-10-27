<?php

declare(strict_types=1);

namespace RKocak\Vallet\Facades;

use Illuminate\Support\Facades\Facade;
use RKocak\Vallet\Contracts\{PaymentContract, RefundContract, ValletContract};

/**
 * @method static PaymentContract createPayment()
 * @method static RefundContract createRefund()
 */
class Vallet extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ValletContract::class;
    }
}
