<?php

namespace Tests\Feature;

use NGT\Ewus\Connections\HttpConnection;
use NGT\Ewus\Enums\OperatorType;
use NGT\Ewus\Exceptions\ResponseException;
use NGT\Ewus\Handler;
use NGT\Ewus\Requests\ChangePasswordRequest;
use NGT\Ewus\Requests\LoginRequest;
use NGT\Ewus\Responses\LoginResponse;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
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

    public function testChangePassword(): void
    {
        $login = $this->login();

        $request = new ChangePasswordRequest();
        $request->setSessionId($login->getSessionId());
        $request->setToken($login->getToken());
        $request->setDomain('01');
        $request->setLogin('TEST');
        $request->setOldPassword('qwerty!@#');
        $request->setNewPassword('asdfgh#@!');
        $request->setOperatorId('123456789');
        $request->setOperatorType(OperatorType::PROVIDER);

        /** @var \NGT\Ewus\Responses\ChangePasswordResponse */
        $response = $this->handler->handle($request);

        $this->assertSame(
            'Hasło zostało zmienione. Zmiana zostanie zatwierdzona po powtórnym zalogowaniu operatora.',
            $response->getChangePasswordMessage()
        );
    }

    public function testChangePasswordWithInvalidData(): void
    {
        $this->expectException(ResponseException::class);
        $this->expectExceptionCode(422);
        $this->expectExceptionMessage('Błędne dane wejściowe.');

        $login = $this->login();

        $request = new ChangePasswordRequest();
        $request->setSessionId($login->getSessionId());
        $request->setToken($login->getToken());
        $request->setDomain('01');
        $request->setLogin('INVALID');
        $request->setOldPassword('qwerty!@#');
        $request->setNewPassword('asdfgh#@!');
        $request->setOperatorId('123456789');
        $request->setOperatorType(OperatorType::PROVIDER);

        $this->handler->handle($request);
    }
}
