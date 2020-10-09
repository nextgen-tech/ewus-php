<?php
declare(strict_types=1);

namespace Tests\Unit\Responses;

use NGT\Ewus\Responses\Response;
use Tests\Support\TestRequest;
use Tests\Support\TestResponse;
use Tests\TestCase;

class ResponseTest extends TestCase
{
    /**
     * The response instance.
     *
     * @var  \Tests\Support\TestResponse
     */
    private $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new TestResponse(new TestRequest(), 'foo');
    }

    /**
     * @covers \NGT\Ewus\Responses\Response::__construct
     * @covers \NGT\Ewus\Responses\Response::getRequest
     * @covers \NGT\Ewus\Responses\Response::getXml
     */
    public function testBaseRequest(): void
    {
        $this->response = new TestResponse(new TestRequest(), 'foo');

        $this->assertInstanceOf(TestRequest::class, $this->response->getRequest());
        $this->assertSame('foo', $this->response->getXml());
    }
}
