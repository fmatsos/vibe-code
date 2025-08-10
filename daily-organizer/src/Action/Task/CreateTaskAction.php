<?php

namespace App\Action\Task;

use App\Domain\Task\TaskService;
use App\Responder\TaskResponder;

class CreateTaskAction
{
    public function __construct(private TaskService $service, private TaskResponder $responder)
    {
    }

    public function __invoke(string $owner, string $title, string $dueDate): array
    {
        $task = $this->service->create($owner, $title, $dueDate);
        return $this->responder->respond($task);
    }
}
