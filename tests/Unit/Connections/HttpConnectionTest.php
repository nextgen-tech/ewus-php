<?php
declare(strict_types=1);

namespace Tests\Unit\Connections;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use NGT\Ewus\Connections\HttpConnection as BaseHttpConnection;
use NGT\Ewus\Exceptions\ResponseException;
use Tests\Support\TestRequest;
use Tests\Support\TestService;
use Tests\TestCase;

class HttpConnectionTest extends TestCase
{
    /**
     * The connection instance.
     *
     * @var  \Tests\Unit\Connections\HttpConnection
     */
    private $connection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = new HttpConnection();
        $this->connection->setService(new TestService());
    }

    public function testCachingClientInstance(): void
    {
        $client = $this->connection->getClient();

        $this->assertSame($client, $this->connection->getClient());
    }

    public function testSendMethod(): void
    {
        $request = new TestRequest();

        $this->connection->mockResponse(new Response(200, [], 'Test response'));

        $this->assertSame('Test response', $this->connection->send($request->toXml()));
    }

    public function testSendMethodWithServerError(): void
    {
        $request = new TestRequest();

        $this->connection->mockResponse(new ServerException(
            'Test exception message.',
            new Request('POST', '/'),
            new Response(500, [], 'Test server error')
        ));

        $this->assertSame('Test server error', $this->connection->send($request->toXml()));
    }

    public function testSendMethodWithClientError(): void
    {
        $request = new TestRequest();

        $this->connection->mockResponse(new ClientException(
            'Test exception message.',
            new Request('POST', '/'),
            new Response(400, [], 'Test client error')
        ));

        $this->assertSame('Test client error', $this->connection->send($request->toXml()));
    }

    public function testSendMethodWithThrowable(): void
    {
        $this->expectException(ResponseException::class);

        $request = new TestRequest();

        $this->connection->mockResponse('Invalid response');
        $this->connection->send($request->toXml());
    }

    public function testSettingTimeout(): void
    {
        $connection = new BaseHttpConnection();
        $client     = $connection->getClient();

        $this->assertNull($client->getConfig(RequestOptions::TIMEOUT));

        $connection = new BaseHttpConnection(['timeout' => 123]);
        $client     = $connection->getClient();

        $this->assertSame(123, $client->getConfig(RequestOptions::TIMEOUT));
    }
}

class HttpConnection extends BaseHttpConnection
{
    /**
     * @var  mixed[]
     */
    private $response = [];

    /**
     * @param   mixed  $response
     */
    public function mockResponse($response): self
    {
        $this->response = [$response];

        return $this;
    }

    protected function makeClient(): Client
    {
        $mock         = new MockHandler($this->response);
        $handlerStack = HandlerStack::create($mock);

        return new Client(['handler' => $handlerStack]);
    }
}
