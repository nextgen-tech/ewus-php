<?php
declare(strict_types=1);

namespace Tests\Unit\Responses;

use NGT\Ewus\Requests\ChangePasswordRequest;
use NGT\Ewus\Responses\ChangePasswordResponse;
use Tests\TestCase;

class ChangePasswordResponseTest extends TestCase
{
    /**
     * The response instance.
     *
     * @var  \NGT\Ewus\Responses\ChangePasswordResponse
     */
    private $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new ChangePasswordResponse(new ChangePasswordRequest(), '');
    }

    public function testChangePasswordMessageSetter(): void
    {
        $this->assertSame($this->response->setChangePasswordMessage('test'), $this->response);
    }

    public function testChangePasswordMessageGetter(): void
    {
        $this->response->setChangePasswordMessage('test');
        $this->assertSame('test', $this->response->getChangePasswordMessage());

        $this->response->setChangePasswordMessage(null);
        $this->assertSame(null, $this->response->getChangePasswordMessage());
    }
}
