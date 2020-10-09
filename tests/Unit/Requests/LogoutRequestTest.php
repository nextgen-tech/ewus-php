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

    /**
     * @covers \NGT\Ewus\Requests\LogoutRequest::__construct
     */
    public function testConstructorWithParameters(): void
    {
        $this->request = new LogoutRequest('12345678', 'qwertyuiop');

        $this->assertSame('12345678', $this->request->getSessionId());
        $this->assertSame('qwertyuiop', $this->request->getToken());
    }

    /**
     * @covers \NGT\Ewus\Requests\LogoutRequest::getParser
     */
    public function testDefinedParser(): void
    {
        $this->assertInstanceOf(LogoutParser::class, $this->request->getParser());
    }

    /**
     * @covers \NGT\Ewus\Requests\LogoutRequest::getService
     */
    public function testDefinedService(): void
    {
        $this->assertInstanceOf(AuthService::class, $this->request->getService());
    }

    /**
     * @covers \NGT\Ewus\Requests\LogoutRequest::setSessionId
     */
    public function testSessionIdSetter(): void
    {
        $this->assertSame($this->request->setSessionId('12345678'), $this->request);
    }

    /**
     * @covers \NGT\Ewus\Requests\LogoutRequest::getSessionId
     */
    public function testSessionIdGetter(): void
    {
        $this->request->setSessionId('12345678');

        $this->assertSame('12345678', $this->request->getSessionId());
    }

    /**
     * @covers \NGT\Ewus\Requests\LogoutRequest::getSessionId
     */
    public function testSessionIdGetterWithoutSetter(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->request->getSessionId();
    }

    /**
     * @covers \NGT\Ewus\Requests\LogoutRequest::setToken
     */
    public function testTokenSetter(): void
    {
        $this->assertSame($this->request->setToken('qwertyuiop'), $this->request);
    }

    /**
     * @covers \NGT\Ewus\Requests\LogoutRequest::getToken
     */
    public function testTokenGetter(): void
    {
        $this->request->setToken('qwertyuiop');

        $this->assertSame('qwertyuiop', $this->request->getToken());
    }

    /**
     * @covers \NGT\Ewus\Requests\LogoutRequest::getToken
     */
    public function testTokenGetterWithoutSetter(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->request->getToken();
    }

    /**
     * @covers \NGT\Ewus\Requests\LogoutRequest::envelopeNamespaces
     * @covers \NGT\Ewus\Requests\LogoutRequest::envelopeHeader
     * @covers \NGT\Ewus\Requests\LogoutRequest::envelopeBody
     */
    public function testEnvelope(): void
    {
        $this->request->setSessionId('12345678');
        $this->request->setToken('qwertyuiop');

        $xml = $this->xmlRequest('LogoutRequest.xml');

        $this->assertSame($xml, $this->request->toXml());
    }
}
