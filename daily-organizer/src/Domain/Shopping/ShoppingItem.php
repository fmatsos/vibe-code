<?php

namespace App\Domain\Shopping;

class ShoppingItem
{
    private string $name;
    private bool $purchased = false;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isPurchased(): bool
    {
        return $this->purchased;
    }

    public function markPurchased(): void
    {
        $this->purchased = true;
    }
}
