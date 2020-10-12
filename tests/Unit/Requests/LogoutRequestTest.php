<?php
declare(strict_types=1);

namespace Tests\Unit\Requests;

use InvalidArgumentException;
use NGT\Ewus\Parsers\LogoutParser;
use NGT\Ewus\Requests\LogoutRequest;
use NGT\Ewus\Services\AuthService;
use Tests\TestCase;

class LogoutRequestTest extends TestCase
{
    /**
     * The request instance.
     *
     * @var  \NGT\Ewus\Requests\LogoutRequest
     */
    private $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new LogoutRequest();
    }

    public function testConstructorWithParameters(): void
    {
        $this->request = new LogoutRequest('12345678', 'qwertyuiop');

        $this->assertSame('12345678', $this->request->getSessionId());
        $this->assertSame('qwertyuiop', $this->request->getToken());
    }

    public function testDefinedParser(): void
    {
        $this->assertInstanceOf(LogoutParser::class, $this->request->getParser());
    }

    public function testDefinedService(): void
    {
        $this->assertInstanceOf(AuthService::class, $this->request->getService());
    }

    public function testSessionIdSetter(): void
    {
        $this->assertSame($this->request->setSessionId('12345678'), $this->request);
    }

    public function testSessionIdGetter(): void
    {
        $this->request->setSessionId('12345678');

        $this->assertSame('12345678', $this->request->getSessionId());
    }

    public function testSessionIdGetterWithoutSetter(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->request->getSessionId();
    }

    public function testTokenSetter(): void
    {
        $this->assertSame($this->request->setToken('qwertyuiop'), $this->request);
    }

    public function testTokenGetter(): void
    {
        $this->request->setToken('qwertyuiop');

        $this->assertSame('qwertyuiop', $this->request->getToken());
    }

    public function testTokenGetterWithoutSetter(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->request->getToken();
    }

    public function testEnvelope(): void
    {
        $this->request->setSessionId('12345678');
        $this->request->setToken('qwertyuiop');

        $xml = $this->xmlRequest('LogoutRequest.xml');

        $this->assertSame($xml, $this->request->toXml());
    }
}
