<?php

namespace App\Controller\Task;

use App\Domain\Task\TaskService;
use App\Entity\Task;
use App\Form\TaskEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

#[Route('/tasks/{id}/edit', name: 'task_edit', methods: ['GET', 'POST'])]
class TaskEditAction
{
    public function __construct(
        private TaskService $tasks,
        private FormFactoryInterface $forms,
        private Environment $twig,
        private RouterInterface $router,
    ) {
    }

    public function __invoke(Task $task, Request $request): Response
    {
        $form = $this->forms->create(TaskEditType::class, [
            'title' => $task->getTitle(),
            'dueDate' => $task->getDueDate(),
            'status' => $task->getStatus(),
            'category' => $task->getCategory(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $dueDate = $data['dueDate'];
            $this->tasks->update(
                $task,
                $data['title'],
                $dueDate instanceof \DateTimeInterface ? $dueDate->format('Y-m-d') : (string) $dueDate,
                $data['status'],
                $data['category'],
            );
            return new RedirectResponse($this->router->generate('task_index'));
        }

        return new Response($this->twig->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]));
    }
}
