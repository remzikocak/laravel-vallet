<?php

declare(strict_types=1);

namespace RKocak\Vallet;

use Illuminate\Contracts\Support\Arrayable;
use RKocak\Vallet\Enums\ProductType;

class Product implements Arrayable
{
    protected int|float $price;

    protected string $name;

    protected ?ProductType $type = null;

    public static function make(): self
    {
        return new static();
    }

    public function setType(ProductType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setPrice(int|float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float|int
    {
        return $this->price;
    }

    public function getType(): ?ProductType
    {
        return $this->type;
    }

    /**
     * @throws Exceptions\InvalidArgumentException
     */
    public function toArray(): array
    {
        $this->validate();

        return [
            'productName'  => $this->name,
            'productPrice' => $this->price,
            'productType'  => $this->type->value,
        ];
    }

    protected function validate(): void
    {
        foreach (['price', 'name', 'type'] as $attr) {
            if (empty($this->{$attr})) {
                throw new Exceptions\InvalidArgumentException(__('Product attribute :attribute is not set.', ['attribute' => $attr]));
            }
        }
    }
}
