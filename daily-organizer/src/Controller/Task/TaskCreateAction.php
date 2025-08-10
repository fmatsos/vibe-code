<?php

namespace App\Controller\Task;

use App\Domain\Task\TaskService;
use App\Form\TaskType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

#[Route('/tasks/new', name: 'task_new', methods: ['GET', 'POST'])]
class TaskCreateAction
{
    public function __construct(
        private TaskService $tasks,
        private FormFactoryInterface $forms,
        private Environment $twig,
        private RouterInterface $router,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->forms->create(TaskType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $dueDate = $data['dueDate'];
            $this->tasks->create(
                $data['owner'],
                $data['title'],
                $dueDate instanceof \DateTimeInterface ? $dueDate->format('Y-m-d') : (string) $dueDate,
                $data['status'],
                $data['category'],
            );
            return new RedirectResponse($this->router->generate('task_index'));
        }

        return new Response($this->twig->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
