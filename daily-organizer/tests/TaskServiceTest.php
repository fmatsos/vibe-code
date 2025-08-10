<?php

namespace App\Tests;

use App\Domain\Task\TaskService;
use App\Domain\User\UserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskServiceTest extends KernelTestCase
{
    use DatabaseTestTrait;

    private TaskService $service;
    private UserService $userService;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->setUpDatabase();
        $this->service = self::getContainer()->get(TaskService::class);
        $this->userService = self::getContainer()->get(UserService::class);
        $this->userService->register('john@example.com', 'secret');
        $this->userService->register('alice@example.com', 'secret');
    }

    public function testCreateTask(): void
    {
        $task = $this->service->create('john@example.com', 'Buy milk', '2025-01-10');
        self::assertSame('to do', $task->getStatus());
    }

    public function testUpdateTaskStatus(): void
    {
        $this->service->create('john@example.com', 'Buy milk', '2025-01-10');
        $this->service->updateStatus('john@example.com', 'Buy milk', 'in progress');
        $tasks = $this->service->filterByStatus('john@example.com', 'in progress');
        self::assertCount(1, $tasks);
    }

    public function testDeleteTask(): void
    {
        $this->service->create('john@example.com', 'Buy milk', '2025-01-10');
        $this->service->delete('john@example.com', 'Buy milk');
        self::assertCount(0, $this->service->all('john@example.com'));
    }

    public function testFilterByStatus(): void
    {
        $this->service->create('john@example.com', 'Buy milk', '2025-01-10');
        $this->service->create('john@example.com', 'Pay bills', '2025-01-11');
        $this->service->updateStatus('john@example.com', 'Pay bills', 'done');
        $tasks = $this->service->filterByStatus('john@example.com', 'done');
        self::assertSame('Pay bills', $tasks[0]->getTitle());
    }

    public function testFilterByDate(): void
    {
        $this->service->create('john@example.com', 'Buy milk', '2025-01-10');
        $this->service->create('john@example.com', 'Pay bills', '2025-02-10');
        $tasks = $this->service->filterByDueDate('john@example.com', '2025-01-10');
        self::assertSame('Buy milk', $tasks[0]->getTitle());
    }
}
