<?php

namespace App\Domain\Shopping;

class ShoppingList
{
    private string $owner;
    private string $name;
    /** @var array<string, ShoppingItem> */
    private array $items = [];

    public function __construct(string $owner, string $name)
    {
        $this->owner = $owner;
        $this->name = $name;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ShoppingItem[]
     */
    public function getItems(): array
    {
        return array_values($this->items);
    }

    public function addItem(string $name): ShoppingItem
    {
        $item = new ShoppingItem($name);
        $this->items[$name] = $item;
        return $item;
    }

    public function removeItem(string $name): void
    {
        unset($this->items[$name]);
    }

    public function markPurchased(string $name): void
    {
        if (isset($this->items[$name])) {
            $this->items[$name]->markPurchased();
        }
    }

    public function hasItem(string $name): bool
    {
        return isset($this->items[$name]);
    }
}
