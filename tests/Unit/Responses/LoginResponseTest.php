<?php
declare(strict_types=1);

namespace Tests\Unit\Responses;

use NGT\Ewus\Requests\LoginRequest;
use NGT\Ewus\Responses\LoginResponse;
use Tests\TestCase;

class LoginResponseTest extends TestCase
{
    /**
     * The response instance.
     *
     * @var  \NGT\Ewus\Responses\LoginResponse
     */
    private $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new LoginResponse(new LoginRequest(), '');
    }

    public function testSessionIdSetter(): void
    {
        $this->assertSame($this->response->setSessionId('12345678'), $this->response);
    }

    public function testSessionIdGetter(): void
    {
        $this->response->setSessionId('12345678');
        $this->assertSame('12345678', $this->response->getSessionId());
    }

    public function testTokenSetter(): void
    {
        $this->assertSame($this->response->setToken('qwertyuiop'), $this->response);
    }

    public function testTokenGetter(): void
    {
        $this->response->setToken('qwertyuiop');
        $this->assertSame('qwertyuiop', $this->response->getToken());
    }

    public function testLoginCodeSetter(): void
    {
        $this->assertSame($this->response->setLoginCode('001'), $this->response);
    }

    public function testLoginCodeGetter(): void
    {
        $this->response->setLoginCode('001');
        $this->assertSame('001', $this->response->getLoginCode());
    }

    public function testLoginMessageSetter(): void
    {
        $this->assertSame($this->response->setLoginMessage('test'), $this->response);
    }

    public function testLoginMessageGetter(): void
    {
        $this->response->setLoginMessage('test');
        $this->assertSame('test', $this->response->getLoginMessage());
    }
}
