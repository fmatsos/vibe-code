<?php

namespace App\Tests;

use App\Action\Auth\LoginAction;
use App\Action\Auth\RegisterAction;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AuthActionTest extends KernelTestCase
{
    use DatabaseTestTrait;

    private RegisterAction $registerAction;
    private LoginAction $loginAction;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->setUpDatabase();
        $container = self::getContainer();
        $this->registerAction = $container->get(RegisterAction::class);
        $this->loginAction = $container->get(LoginAction::class);
    }

    public function testRegisterAndLogin(): void
    {
        $register = ($this->registerAction)('john@example.com', 'secret');
        self::assertSame('john@example.com', $register['email']);
        $login = ($this->loginAction)('john@example.com', 'secret');
        self::assertTrue($login['authenticated']);
    }
}
