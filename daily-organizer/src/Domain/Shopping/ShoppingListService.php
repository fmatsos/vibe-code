<?php

namespace App\Domain\Shopping;

class ShoppingListService
{
    /** @var array<string, array<string, ShoppingList>> */
    private array $lists = [];

    public function createList(string $owner, string $name): ShoppingList
    {
        $list = new ShoppingList($owner, $name);
        $this->lists[$owner][$name] = $list;
        return $list;
    }

    public function getList(string $owner, string $name): ?ShoppingList
    {
        return $this->lists[$owner][$name] ?? null;
    }
}
