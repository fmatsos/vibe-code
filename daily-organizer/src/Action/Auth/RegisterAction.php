<?php

namespace App\Action\Auth;

use App\Domain\User\UserService;
use App\Responder\RegisterResponder;

class RegisterAction
{
    public function __construct(
        private UserService $service,
        private RegisterResponder $responder,
    ) {
    }

    public function __invoke(string $email, string $password): array
    {
        $user = $this->service->register($email, $password);
        return ($this->responder)($user);
    }
}
