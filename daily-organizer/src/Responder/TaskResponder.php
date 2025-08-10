<?php

namespace App\Responder;

use App\Entity\Task;

class TaskResponder
{
    public function respond(Task $task): array
    {
        return [
            'owner' => $task->getUser()->getEmail(),
            'title' => $task->getTitle(),
            'dueDate' => $task->getDueDate()->format('Y-m-d'),
            'status' => $task->getStatus(),
            'category' => $task->getCategory(),
        ];
    }

    public function __invoke(Task $task): array
    {
        return $this->respond($task);
    }
}
