<?php

namespace App\Controller\Task;

use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[Route('/tasks', name: 'task_index', methods: ['GET'])]
class TaskListAction
{
    public function __construct(private TaskRepository $tasks, private Environment $twig)
    {
    }

    public function __invoke(): Response
    {
        return new Response($this->twig->render('task/index.html.twig', [
            'tasks' => $this->tasks->findAll(),
        ]));
    }
}
