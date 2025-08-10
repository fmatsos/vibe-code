<?php

namespace App\Domain\Notification;

use App\Domain\Appointment\AppointmentService;
use App\Domain\Task\TaskService;

class NotificationService
{
    public function __construct(
        private TaskService $taskService,
        private AppointmentService $appointmentService
    ) {
    }

    /**
     * @return string[]
     */
    public function taskReminders(string $owner, \DateTimeImmutable $now): array
    {
        $notifications = [];
        foreach ($this->taskService->all($owner) as $task) {
            if ($task->getDueDate()->format('Y-m-d') === $now->format('Y-m-d')) {
                $notifications[] = $task->getTitle();
            }
        }
        return $notifications;
    }

    /**
     * @return string[]
     */
    public function appointmentReminders(string $owner, \DateTimeImmutable $now): array
    {
        $notifications = [];
        foreach ($this->appointmentService->all($owner) as $appointment) {
            $reminderTime = $appointment->getStart()->modify('-15 minutes');
            if ($reminderTime <= $now && $appointment->getStart() > $now) {
                $notifications[] = $appointment->getTitle();
            }
        }
        return $notifications;
    }
}
