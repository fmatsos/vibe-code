<?php

namespace App\Responder;

use App\Entity\User;

class RegisterResponder
{
    public function __invoke(User $user): array
    {
        return [
            'email' => $user->getEmail(),
        ];
    }
}
