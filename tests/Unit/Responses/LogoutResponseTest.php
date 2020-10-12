<?php
declare(strict_types=1);

namespace Tests\Unit\Responses;

use NGT\Ewus\Requests\LogoutRequest;
use NGT\Ewus\Responses\LogoutResponse;
use Tests\TestCase;

class LogoutResponseTest extends TestCase
{
    /**
     * The response instance.
     *
     * @var  \NGT\Ewus\Responses\LogoutResponse
     */
    private $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new LogoutResponse(new LogoutRequest(), '');
    }

    public function testLogoutMessageSetter(): void
    {
        $this->assertSame($this->response->setLogoutMessage('test'), $this->response);
    }

    public function testLogoutMessageGetter(): void
    {
        $this->response->setLogoutMessage('test');
        $this->assertSame('test', $this->response->getLogoutMessage());

        $this->response->setLogoutMessage(null);
        $this->assertSame(null, $this->response->getLogoutMessage());
    }
}
