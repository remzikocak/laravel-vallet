<?php

declare(strict_types=1);

namespace RKocak\Vallet\Enums;

enum ProductType: string
{
    case Physical = 'FIZIKSEL_URUN';

    case Digital = 'DIJITAL_URUN';
}
