<?php

namespace App\Domain\Task;

use App\Domain\User\UserService;
use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{
    public function __construct(
        private TaskRepository $tasks,
        private UserRepository $users,
        private UserService $userService,
        private EntityManagerInterface $em,
    ) {
    }

    public function create(string $owner, string $title, string $dueDate, string $status = 'to do', string $category = 'General'): Task
    {
        $user = $this->users->findOneByEmail($owner);
        if ($user === null) {
            $user = $this->userService->register($owner, 'secret');
        }

        $task = new Task($user, $title, new \DateTimeImmutable($dueDate), $status, $category);
        $this->em->persist($task);
        $this->em->flush();

        return $task;
    }

    public function updateStatus(string $owner, string $title, string $status): ?Task
    {
        $user = $this->users->findOneByEmail($owner);
        if ($user === null) {
            return null;
        }
        $task = $this->tasks->findOneBy(['user' => $user, 'title' => $title]);
        if ($task === null) {
            return null;
        }
        $task->setStatus($status);
        $this->em->flush();

        return $task;
    }

    public function update(Task $task, string $title, string $dueDate, string $status, string $category): Task
    {
        $task->setTitle($title);
        $task->setDueDate(new \DateTimeImmutable($dueDate));
        $task->setStatus($status);
        $task->setCategory($category);
        $this->em->flush();

        return $task;
    }

    public function delete(Task $task): void
    {
        $this->em->remove($task);
        $this->em->flush();
    }

    /**
     * @return Task[]
     */
    public function filterByStatus(string $owner, string $status): array
    {
        $user = $this->users->findOneByEmail($owner);
        if ($user === null) {
            return [];
        }

        return $this->tasks->findByStatus($user, $status);
    }

    /**
     * @return Task[]
     */
    public function filterByDueDate(string $owner, string $date): array
    {
        $user = $this->users->findOneByEmail($owner);
        if ($user === null) {
            return [];
        }

        return $this->tasks->findByDueDate($user, new \DateTimeImmutable($date));
    }

    /**
     * @return Task[]
     */
    public function all(string $owner): array
    {
        $user = $this->users->findOneByEmail($owner);
        if ($user === null) {
            return [];
        }

        return $this->tasks->findAllByUser($user);
    }
}
