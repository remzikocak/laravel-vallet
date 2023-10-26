<?php

declare(strict_types=1);

namespace RKocak\Vallet\Contracts;

use Illuminate\Support\Carbon;
use RKocak\Vallet\Enums\{Currency, ProductType};

interface ResponseContract
{
    public function validate(): void;

    public function getOrderId(): string;

    public function getCurrency(): Currency;

    public function getOrderPrice(): string|float;

    public function getProductsTotalPrice(): string|float;

    public function getProductType(): ProductType;

    public function getStatus(): string;

    public function getAmount(): string|float;

    public function getPaymentType(): string;

    public function getPaymentTime(): Carbon;

    public function getConversationId(): string;

    public function getCallbackOkUrl(): string;

    public function getCallbackFailUrl(): string;

    public function getShopCode(): string;

    public function isPaid(): bool;

    public function isNotPaid(): bool;

    public function isAwaitingVerification(): bool;

    public function isPending(): bool;

    public function getValletOrderId(): int;
}
