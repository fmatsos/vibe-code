<?php

namespace App\Tests;

use App\Controller\Task\TaskCreateAction;
use App\Controller\Task\TaskListAction;
use App\Domain\Task\TaskService;
use App\Domain\User\UserService;
use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class TaskCrudActionTest extends KernelTestCase
{
    use DatabaseTestTrait;

    private TaskListAction $listAction;
    private TaskCreateAction $createAction;
    private User $user;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->setUpDatabase();
        $container = self::getContainer();
        $hasher = new class() implements UserPasswordHasherInterface {
            public function hashPassword(PasswordAuthenticatedUserInterface $user, string $plainPassword): string
            {
                return $plainPassword;
            }
            public function isPasswordValid(PasswordAuthenticatedUserInterface $user, string $plainPassword): bool
            {
                return $user->getPassword() === $plainPassword;
            }
            public function needsRehash(PasswordAuthenticatedUserInterface $user): bool
            {
                return false;
            }
        };
        $userService = new UserService(
            $container->get(UserRepository::class),
            $hasher,
            $this->em,
        );
        $taskService = new TaskService(
            $container->get(TaskRepository::class),
            $container->get(UserRepository::class),
            $userService,
            $this->em,
        );
        $this->listAction = new TaskListAction(
            $container->get(TaskRepository::class),
            $container->get('twig'),
        );
        $this->createAction = new TaskCreateAction(
            $taskService,
            Forms::createFormFactoryBuilder()->addExtension(new HttpFoundationExtension())->getFormFactory(),
            $container->get('twig'),
            $container->get('router'),
        );
        $this->user = new User();
        $this->user->setEmail('john@example.com');
        $this->user->setPassword('secret');
        $this->em->persist($this->user);
        $this->em->flush();
    }

    public function testIndexShowsTasks(): void
    {
        $task = new Task($this->user, 'Buy milk', new \DateTimeImmutable('2025-01-01'));
        $this->em->persist($task);
        $this->em->flush();

        $response = ($this->listAction)();
        self::assertStringContainsString('Buy milk', $response->getContent());
    }

    public function testCreateTask(): void
    {
        $request = Request::create('/tasks/new', 'POST', [
            'task' => [
                'owner' => 'john@example.com',
                'title' => 'Pay bills',
                'dueDate' => '2025-02-02',
                'status' => 'to do',
                'category' => 'Finance',
            ],
        ]);

        $response = ($this->createAction)($request);
        self::assertInstanceOf(RedirectResponse::class, $response);
        $tasks = $this->em->getRepository(Task::class)->findAll();
        self::assertCount(1, $tasks);
        self::assertSame('Pay bills', $tasks[0]->getTitle());
    }
}
