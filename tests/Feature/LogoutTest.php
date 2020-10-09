<?php

namespace Tests\Feature;

use NGT\Ewus\Connections\HttpConnection;
use NGT\Ewus\Enums\OperatorType;
use NGT\Ewus\Handler;
use NGT\Ewus\Requests\LoginRequest;
use NGT\Ewus\Requests\LogoutRequest;
use NGT\Ewus\Responses\LoginResponse;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * The handler instance.
     *
     * @var  \NGT\Ewus\Handler
     */
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new Handler();
        $this->handler->setConnection(new HttpConnection());
        $this->handler->enableSandboxMode();
    }

    private function login(): LoginResponse
    {
        $request = new LoginRequest('01', 'TEST', 'qwerty!@#', '123456789', OperatorType::PROVIDER);

        /** @var \NGT\Ewus\Responses\LoginResponse */
        return $this->handler->handle($request);
    }

    public function testLogout(): void
    {
        $login = $this->login();

        $request = new LogoutRequest();
        $request->setSessionId($login->getSessionId());
        $request->setToken($login->getToken());

        /** @var \NGT\Ewus\Responses\LogoutResponse */
        $response = $this->handler->handle($request);

        $this->assertSame('Wylogowany', $response->getLogoutMessage());
    }
}
