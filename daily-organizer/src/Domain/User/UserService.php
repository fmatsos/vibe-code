<?php

namespace App\Domain\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    /** @var array<string, bool> */
    private array $sessions = [];
    /** @var array<string, bool> */
    private array $passwordResets = [];

    public function __construct(
        private UserRepository $users,
        private UserPasswordHasherInterface $hasher,
        private EntityManagerInterface $em,
    ) {
    }

    public function register(string $email, string $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->hasher->hashPassword($user, $password));
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->users->findOneByEmail($email);
        if ($user && $this->hasher->isPasswordValid($user, $password)) {
            $this->sessions[$email] = true;
            return true;
        }

        return false;
    }

    public function logout(string $email): void
    {
        unset($this->sessions[$email]);
    }

    public function isAuthenticated(string $email): bool
    {
        return $this->sessions[$email] ?? false;
    }

    public function requestPasswordReset(string $email): void
    {
        if ($this->users->findOneByEmail($email)) {
            $this->passwordResets[$email] = true;
        }
    }

    public function hasPasswordReset(string $email): bool
    {
        return $this->passwordResets[$email] ?? false;
    }
}
