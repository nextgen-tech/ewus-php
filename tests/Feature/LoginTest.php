<?php

namespace Tests\Feature;

use NGT\Ewus\Connections\HttpConnection;
use NGT\Ewus\Enums\OperatorType;
use NGT\Ewus\Exceptions\ResponseException;
use NGT\Ewus\Handler;
use NGT\Ewus\Requests\LoginRequest;
use Tests\TestCase;

class LoginTest extends TestCase
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

    public function testLogin(): void
    {
        $request = new LoginRequest();
        $request->setDomain('01');
        $request->setLogin('TEST');
        $request->setPassword('qwerty!@#');
        $request->setOperatorId('123456789');
        $request->setOperatorType(OperatorType::PROVIDER);

        /** @var \NGT\Ewus\Responses\LoginResponse */
        $response = $this->handler->handle($request);

        $this->assertSame('000', $response->getLoginCode());
        $this->assertSame('Użytkownik został prawidłowo zalogowany.', $response->getLoginMessage());
        $this->assertSame(32, mb_strlen($response->getSessionId() ?? ''));
        $this->assertSame(22, mb_strlen($response->getToken() ?? ''));
    }

    public function testLoginWithInvalidData(): void
    {
        $this->expectException(ResponseException::class);
        $this->expectExceptionCode(401);
        $this->expectExceptionMessage('Brak identyfikacji operatora. Podane parametry logowania są nieprawidłowe.');

        $request = new LoginRequest();
        $request->setDomain('01');
        $request->setLogin('INVALID');
        $request->setPassword('qwerty!@#');
        $request->setOperatorId('123456789');
        $request->setOperatorType(OperatorType::PROVIDER);

        $response = $this->handler->handle($request);
    }
}
