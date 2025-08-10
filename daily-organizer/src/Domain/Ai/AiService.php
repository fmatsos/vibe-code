<?php

namespace App\Domain\Ai;

use App\Domain\Appointment\AppointmentService;
use App\Domain\Shopping\ShoppingListService;
use App\Domain\Task\TaskService;

class AiService
{
    /** @var array<string, array<string,int>> */
    private array $commonItems = [];

    public function __construct(
        private TaskService $taskService,
        private AppointmentService $appointmentService,
        private ShoppingListService $shoppingListService
    ) {
    }

    public function parseEntry(string $owner, string $text): void
    {
        if (preg_match('/^Call the (.+) tomorrow at (\d{1,2})pm$/i', $text, $m)) {
            $title = 'Call the ' . $m[1];
            $hour = (int)$m[2];
            $date = (new \DateTimeImmutable('tomorrow'))->setTime($hour + 12, 0);
            $this->appointmentService->create($owner, $title, '', $date->format('Y-m-d H:i'), $date->modify('+1 hour')->format('Y-m-d H:i'));
        } elseif (preg_match('/^Create task "(.+)"$/i', $text, $m)) {
            $this->taskService->create($owner, $m[1], (new \DateTimeImmutable('tomorrow'))->format('Y-m-d'));
        }
    }

    /**
     * @return string[]
     */
    public function suggestItems(string $owner): array
    {
        return array_keys($this->commonItems[$owner] ?? []);
    }

    public function trackItem(string $owner, string $item): void
    {
        $this->commonItems[$owner][$item] = ($this->commonItems[$owner][$item] ?? 0) + 1;
    }

    public function categorizeTask(string $title): string
    {
        if (str_contains(strtolower($title), 'meeting')) {
            return 'Work';
        }
        return 'General';
    }

    /**
     * @return string[] task titles sorted by priority (soonest first)
     */
    public function prioritizeTasks(string $owner): array
    {
        $tasks = $this->taskService->all($owner);
        usort($tasks, fn ($a, $b) => $a->getDueDate() <=> $b->getDueDate());
        return array_map(fn ($t) => $t->getTitle(), $tasks);
    }
}
