<?php
declare(strict_types=1);

namespace Tests\Unit;

use InvalidArgumentException;
use NGT\Ewus\Enums\OperatorType;
use NGT\Ewus\Parsers\LoginParser;
use NGT\Ewus\Requests\LoginRequest;
use NGT\Ewus\Services\AuthService;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    /**
     * The request instance.
     *
     * @var  \NGT\Ewus\Requests\LoginRequest
     */
    private $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new LoginRequest();
    }

    public function testConstructorWithParameters(): void
    {
        $this->request = new LoginRequest('15', 'TEST1', 'qwerty!@#');

        $this->assertSame('15', $this->request->getDomain());
        $this->assertSame('TEST1', $this->request->getLogin());
        $this->assertSame('qwerty!@#', $this->request->getPassword());
    }

    public function testDefinedParser(): void
    {
        $this->assertInstanceOf(LoginParser::class, $this->request->getParser());
    }

    public function testDefinedService(): void
    {
        $this->assertInstanceOf(AuthService::class, $this->request->getService());
    }

    public function testPasswordSetter(): void
    {
        $this->assertSame($this->request->setPassword('test'), $this->request);
    }

    public function testPasswordGetter(): void
    {
        $this->request->setPassword('test');

        $this->assertSame('test', $this->request->getPassword());
    }

    public function testPasswordGetterWithoutSetter(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->request->getPassword();
    }

    public function testEnvelope(): void
    {
        $this->request->setDomain('01');
        $this->request->setLogin('TEST1');
        $this->request->setPassword('qwerty!@#');
        $this->request->setOperatorId('12345');
        $this->request->setOperatorType(OperatorType::PROVIDER);

        $xml = $this->xmlRequest('LoginRequest.xml');

        $this->assertSame($xml, $this->request->toXml());
    }
}
