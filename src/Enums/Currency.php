<?php

declare(strict_types=1);

namespace RKocak\Vallet\Enums;

enum Currency: string
{
    case Usd = 'USD';

    case Eur = 'EUR';

    case Try = 'TRY';

    public function label(): string
    {
        return match ($this) {
            self::Usd => __('vallet::vallet.currency.usd'),
            self::Eur => __('vallet::vallet.currency.eur'),
            self::Try => __('vallet::vallet.currency.try'),
        };
    }
}
