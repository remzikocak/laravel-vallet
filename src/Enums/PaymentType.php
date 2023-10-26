<?php

declare(strict_types=1);

namespace RKocak\Vallet\Enums;

enum PaymentType: string
{
    case BANKA_HAVALE = 'BANKA_HAVALE';

    case YURT_DISI = 'YURT_DISI';

    case KART = 'KART';

    public function label(): string
    {
        return trans('vallet::vallet.paymentType.'.$this->value);
    }
}
