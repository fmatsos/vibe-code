<?php

namespace App\Tests;

use App\Domain\Appointment\AppointmentService;
use App\Domain\Notification\NotificationService;
use App\Domain\Task\TaskService;
use App\Domain\User\UserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NotificationServiceTest extends KernelTestCase
{
    use DatabaseTestTrait;

    private NotificationService $service;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->setUpDatabase();
        $container = self::getContainer();
        $container->get(UserService::class)->register('john@example.com', 'secret');
        $taskService = $container->get(TaskService::class);
        $appointmentService = $container->get(AppointmentService::class);
        $this->service = $container->get(NotificationService::class);
        $taskService->create('john@example.com', 'Pay bills', '2025-01-10');
        $appointmentService->create('john@example.com', 'Dentist', 'Clinic', '2025-01-10 14:00', '2025-01-10 15:00');
    }

    public function testTaskReminder(): void
    {
        $notifications = $this->service->taskReminders('john@example.com', new \DateTimeImmutable('2025-01-10'));
        self::assertContains('Pay bills', $notifications);
    }

    public function testAppointmentReminder(): void
    {
        $notifications = $this->service->appointmentReminders('john@example.com', new \DateTimeImmutable('2025-01-10 13:45'));
        self::assertContains('Dentist', $notifications);
    }
}
