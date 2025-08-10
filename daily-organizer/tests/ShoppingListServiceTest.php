<?php

namespace App\Tests;

use App\Domain\Shopping\ShoppingListService;
use PHPUnit\Framework\TestCase;

class ShoppingListServiceTest extends TestCase
{
    private ShoppingListService $service;

    protected function setUp(): void
    {
        $this->service = new ShoppingListService();
    }

    public function testCreateList(): void
    {
        $list = $this->service->createList('john@example.com', 'Supermarket');
        self::assertSame('Supermarket', $list->getName());
    }

    public function testAddItem(): void
    {
        $list = $this->service->createList('john@example.com', 'Supermarket');
        $list->addItem('Milk');
        self::assertTrue($list->hasItem('Milk'));
    }

    public function testRemoveItem(): void
    {
        $list = $this->service->createList('john@example.com', 'Supermarket');
        $list->addItem('Milk');
        $list->removeItem('Milk');
        self::assertFalse($list->hasItem('Milk'));
    }

    public function testMarkPurchased(): void
    {
        $list = $this->service->createList('john@example.com', 'Supermarket');
        $list->addItem('Milk');
        $list->markPurchased('Milk');
        self::assertTrue($list->getItems()[0]->isPurchased());
    }
}
