<?php

declare(strict_types=1);

namespace RKocak\Vallet\Contracts;

use RKocak\Vallet\Exceptions\InvalidArgumentException;
use RKocak\Vallet\RefundResponse;

interface RefundContract
{
    public function setAmount(int|float $amount): self;

    public function setOrderId(string $orderId): self;

    public function setValletOrderId(int $orderId): self;

    /**
     * @throws InvalidArgumentException
     */
    public function process(): RefundResponse;
}
