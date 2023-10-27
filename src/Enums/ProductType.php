<?php

declare(strict_types=1);

namespace RKocak\Vallet\Enums;

enum ProductType: string
{
    case Physical = 'FIZIKSEL_URUN';

    case Digital = 'DIJITAL_URUN';

    public function label(): string
    {
        return match ($this) {
            self::Digital  => __('vallet::vallet.productType.digital'),
            self::Physical => __('vallet::vallet.productType.physical'),
        };
    }
}
