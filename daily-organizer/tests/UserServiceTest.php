<?php

namespace App\Tests;

use App\Domain\Task\TaskService;
use App\Domain\User\UserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserServiceTest extends KernelTestCase
{
    use DatabaseTestTrait;

    private UserService $service;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->setUpDatabase();
        $this->service = self::getContainer()->get(UserService::class);
    }

    public function testRegisterLoginLogout(): void
    {
        $this->service->register('john@example.com', 'secret');
        self::assertTrue($this->service->login('john@example.com', 'secret'));
        self::assertTrue($this->service->isAuthenticated('john@example.com'));
        $this->service->logout('john@example.com');
        self::assertFalse($this->service->isAuthenticated('john@example.com'));
    }

    public function testPasswordReset(): void
    {
        $this->service->register('john@example.com', 'secret');
        $this->service->requestPasswordReset('john@example.com');
        self::assertTrue($this->service->hasPasswordReset('john@example.com'));
    }

    public function testDataIsolation(): void
    {
        $taskService = self::getContainer()->get(TaskService::class);
        $this->service->register('alice@example.com', 'pw');
        $this->service->register('bob@example.com', 'pw');
        $taskService->create('alice@example.com', 'Buy milk', '2025-01-10');
        $tasks = $taskService->all('bob@example.com');
        self::assertCount(0, $tasks);
    }

    public function testTimestampsOnRegister(): void
    {
        $user = $this->service->register('timestamp@example.com', 'pw');
        self::assertNotNull($user->getCreatedAt());
        self::assertNotNull($user->getUpdatedAt());
    }
}
