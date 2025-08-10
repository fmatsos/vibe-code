<?php

namespace App\Tests;

use App\Domain\Ai\AiService;
use App\Domain\Task\TaskService;
use App\Domain\User\UserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AiServiceTest extends KernelTestCase
{
    use DatabaseTestTrait;

    private AiService $ai;
    private TaskService $taskService;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->setUpDatabase();
        $container = self::getContainer();
        $this->taskService = $container->get(TaskService::class);
        $this->ai = $container->get(AiService::class);
        $container->get(UserService::class)->register('john@example.com', 'secret');
    }

    public function testParseEntryCreatesAppointment(): void
    {
        $this->ai->parseEntry('john@example.com', 'Call the dentist tomorrow at 2pm');
        $appointments = self::getContainer()->get(\App\Domain\Appointment\AppointmentService::class)->all('john@example.com');
        self::assertSame('Call the dentist', $appointments[0]->getTitle());
    }

    public function testSuggestItems(): void
    {
        $this->ai->trackItem('john@example.com', 'Milk');
        $suggestions = $this->ai->suggestItems('john@example.com');
        self::assertContains('Milk', $suggestions);
    }

    public function testCategorizeTask(): void
    {
        $category = $this->ai->categorizeTask('Project meeting');
        self::assertSame('Work', $category);
    }

    public function testPrioritizeTasks(): void
    {
        $this->taskService->create('john@example.com', 'Pay bills', (new \DateTimeImmutable('+1 day'))->format('Y-m-d'));
        $this->taskService->create('john@example.com', 'Clean house', (new \DateTimeImmutable('+7 days'))->format('Y-m-d'));
        $priorities = $this->ai->prioritizeTasks('john@example.com');
        self::assertSame('Pay bills', $priorities[0]);
    }
}
