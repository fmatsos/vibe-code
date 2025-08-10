<?php

namespace App\Tests;

use App\Action\Task\CreateTaskAction;
use App\Domain\User\UserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateTaskActionTest extends KernelTestCase
{
    use DatabaseTestTrait;

    private CreateTaskAction $action;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->setUpDatabase();
        self::getContainer()->get(UserService::class)->register('john@example.com', 'secret');
        $this->action = self::getContainer()->get(CreateTaskAction::class);
    }

    public function testActionReturnsArray(): void
    {
        $result = ($this->action)('john@example.com', 'Buy milk', '2025-01-10');
        self::assertSame('Buy milk', $result['title']);
    }
}
