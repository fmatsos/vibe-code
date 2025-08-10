<?php

namespace App\Controller\Task;

use App\Domain\Task\TaskService;
use App\Entity\Task;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route('/tasks/{id}/delete', name: 'task_delete', methods: ['POST'])]
class TaskDeleteAction
{
    public function __construct(private TaskService $tasks, private RouterInterface $router)
    {
    }

    public function __invoke(Task $task): RedirectResponse
    {
        $this->tasks->delete($task);
        return new RedirectResponse($this->router->generate('task_index'));
    }
}
