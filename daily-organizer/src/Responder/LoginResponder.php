<?php

namespace App\Responder;

class LoginResponder
{
    public function __invoke(bool $success): array
    {
        return ['authenticated' => $success];
    }
}
