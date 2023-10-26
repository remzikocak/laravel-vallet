<?php

declare(strict_types=1);

namespace RKocak\Vallet;

use RKocak\Vallet\Contracts\RefundContract;
use RKocak\Vallet\Exceptions\InvalidArgumentException;
use SensitiveParameter;

class Refund implements RefundContract
{
    const VALLET_REFUND_URL = 'https://www.vallet.com.tr/api/v1/create-refund';

    protected float|int $amount = 0;

    protected ?string $orderId = null;

    protected int $valletOrderId = 0;

    public function __construct(
        #[SensitiveParameter] private readonly ?string $username,
        #[SensitiveParameter] private readonly ?string $password,
        #[SensitiveParameter] private readonly ?string $shopCode,
        #[SensitiveParameter] private readonly ?string $hash,
    ) {

    }

    public function setAmount(int|float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function setValletOrderId(int $orderId): self
    {
        $this->valletOrderId = $orderId;

        return $this;
    }

    public function refund(): void
    {
        if (! $this->amount) {
            throw new InvalidArgumentException(__('Amount is required'));
        }

        if (! $this->orderId && ! $this->valletOrderId) {
            throw new InvalidArgumentException(__('Order ID is required'));
        }

        $hash = $post['userName'].$post['password'].$post['shopCode'].$post['valletOrderId'].$post['orderId'].$post['amount'].$hashKey;
    }
}
