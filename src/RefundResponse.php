<?php

declare(strict_types=1);

namespace RKocak\Vallet;

class RefundResponse
{
    public function __construct(
        protected array $valletResponse
    ) {

    }

    public function success(): bool
    {
        return $this->valletResponse['status'] === 'success';
    }

    public function failed(): bool
    {
        return ! $this->success();
    }

    public function getExtraData(): ?array
    {
        return $this->valletResponse['extraData'] ?? null;
    }

    public function getRefundId(): ?int
    {
        return $this->valletResponse['extraData']['refundId'] ?? null;
    }
}
