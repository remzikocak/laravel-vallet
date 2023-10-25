<?php

declare(strict_types=1);

namespace RKocak\Vallet;

use Illuminate\Config\Repository;
use RKocak\Vallet\Contracts\{PaymentContract, ValletContract};

class Vallet implements ValletContract
{
    public function __construct(
        protected Repository $config
    ) {

    }

    public function createPayment(): PaymentContract
    {
        return new Payment(
            username: $this->config->get('vallet.username'),
            password: $this->config->get('vallet.password'),
            shopCode: $this->config->get('vallet.shopCode'),
            hash: $this->config->get('vallet.hash'),
            callbackOkUrl: $this->config->get('vallet.callbackUrl.ok'),
            callbackFailUrl: $this->config->get('vallet.callbackUrl.fail'),
        );
    }
}
