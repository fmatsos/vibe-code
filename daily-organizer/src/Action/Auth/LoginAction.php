<?php

namespace App\Action\Auth;

use App\Domain\User\UserService;
use App\Responder\LoginResponder;

class LoginAction
{
    public function __construct(
        private UserService $service,
        private LoginResponder $responder,
    ) {
    }

    public function __invoke(string $email, string $password): array
    {
        $success = $this->service->login($email, $password);
        return ($this->responder)($success);
    }
}
