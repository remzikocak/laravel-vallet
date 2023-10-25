<?php

declare(strict_types=1);

namespace RKocak\Vallet\Contracts;

use RKocak\Vallet\Buyer;
use RKocak\Vallet\Enums\{Currency, Locale, ProductType};

interface PaymentContract
{
    public function setCurrency(Currency $currency): self;

    public function setLocale(Locale $locale): self;

    public function setBuyer(Buyer $buyer): self;

    public function setProductName(string $productName): self;

    public function setConversationId(string $conversationId): self;

    public function setOrderId(string $orderId): self;

    public function setProductsTotalPrice(int|float $price): self;

    public function setOrderPrice(int|float $price): self;

    public function setProductType(ProductType $type): self;

    public function toArray(): array;

    public function createLink(): string;
}
