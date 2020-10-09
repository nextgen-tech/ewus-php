<?php
declare(strict_types=1);

namespace Tests\Unit\Requests;

use DateTime;
use DateTimeInterface;
use InvalidArgumentException;
use NGT\Ewus\Parsers\CheckParser;
use NGT\Ewus\Requests\CheckRequest as BaseCheckRequest;
use NGT\Ewus\Services\BrokerService;
use Tests\TestCase;

class CheckRequestTest extends TestCase
{
    /**
     * The request instance.
     *
     * @var  \NGT\Ewus\Requests\CheckRequest
     */
    private $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CheckRequest();
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::__construct
     */
    public function testConstructorWithParameters(): void
    {
        $this->request = new CheckRequest('12345678', 'qwertyuiop', '12345678901');

        $this->assertSame('12345678', $this->request->getSessionId());
        $this->assertSame('qwertyuiop', $this->request->getToken());
        $this->assertSame('12345678901', $this->request->getPesel());
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::getParser
     */
    public function testDefinedParser(): void
    {
        $this->assertInstanceOf(CheckParser::class, $this->request->getParser());
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::getService
     */
    public function testDefinedService(): void
    {
        $this->assertInstanceOf(BrokerService::class, $this->request->getService());
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::setSessionId
     */
    public function testSessionIdSetter(): void
    {
        $this->assertSame($this->request->setSessionId('12345678'), $this->request);
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::getSessionId
     */
    public function testSessionIdGetter(): void
    {
        $this->request->setSessionId('12345678');

        $this->assertSame('12345678', $this->request->getSessionId());
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::getSessionId
     */
    public function testSessionIdGetterWithoutSetter(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->request->getSessionId();
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::setToken
     */
    public function testTokenSetter(): void
    {
        $this->assertSame($this->request->setToken('qwertyuiop'), $this->request);
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::getToken
     */
    public function testTokenGetter(): void
    {
        $this->request->setToken('qwertyuiop');

        $this->assertSame('qwertyuiop', $this->request->getToken());
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::getToken
     */
    public function testTokenGetterWithoutSetter(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->request->getToken();
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::setPesel
     */
    public function testPeselSetter(): void
    {
        $this->assertSame($this->request->setPesel('12345678901'), $this->request);
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::getPesel
     */
    public function testPeselGetter(): void
    {
        $this->request->setPesel('12345678901');

        $this->assertSame('12345678901', $this->request->getPesel());
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::getPesel
     */
    public function testPeselGetterWithoutSetter(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->request->getPesel();
    }

    /**
     * @covers \NGT\Ewus\Requests\CheckRequest::envelopeNamespaces
     * @covers \NGT\Ewus\Requests\CheckRequest::envelopeHeader
     * @covers \NGT\Ewus\Requests\CheckRequest::envelopeBody
     */
    public function testEnvelope(): void
    {
        $this->request->setSessionId('12345678');
        $this->request->setToken('qwertyuiop');
        $this->request->setPesel('12345678901');

        $xml = $this->xmlRequest('CheckRequest.xml');

        $this->assertSame($xml, $this->request->toXml());
    }
}

class CheckRequest extends BaseCheckRequest
{
    /**
     * @inheritDoc
     */
    protected function getRequestDate(): DateTimeInterface
    {
        return new DateTime('2020-01-01 00:00:00');
    }
}
