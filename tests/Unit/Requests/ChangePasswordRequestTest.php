<?php
declare(strict_types=1);

namespace Tests\Unit\Requests;

use InvalidArgumentException;
use NGT\Ewus\Enums\OperatorType;
use NGT\Ewus\Parsers\ChangePasswordParser;
use NGT\Ewus\Requests\ChangePasswordRequest;
use NGT\Ewus\Services\AuthService;
use Tests\TestCase;

class ChangePasswordRequestTest extends TestCase
{
    /**
     * The request instance.
     *
     * @var  \NGT\Ewus\Requests\ChangePasswordRequest
     */
    private $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ChangePasswordRequest();
    }

    public function testConstructorWithParameters(): void
    {
        $this->request = new ChangePasswordRequest('12345678', 'qwertyuiop', '15', 'TEST1', 'qwerty!@#', 'asdfgh!@#');

        $this->assertSame('12345678', $this->request->getSessionId());
        $this->assertSame('qwertyuiop', $this->request->getToken());
        $this->assertSame('15', $this->request->getDomain());
        $this->assertSame('TEST1', $this->request->getLogin());
        $this->assertSame('qwerty!@#', $this->request->getOldPassword());
        $this->assertSame('asdfgh!@#', $this->request->getNewPassword());
    }

    public function testDefinedParser(): void
    {
        $this->assertInstanceOf(ChangePasswordParser::class, $this->request->getParser());
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

    public function testOldPasswordSetter(): void
    {
        $this->assertSame($this->request->setOldPassword('qwerty!@#'), $this->request);
    }

    public function testOldPasswordGetter(): void
    {
        $this->request->setOldPassword('qwerty!@#');

        $this->assertSame('qwerty!@#', $this->request->getOldPassword());
    }

    public function testOldPasswordGetterWithoutSetter(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->request->getOldPassword();
    }

    public function testNewPasswordSetter(): void
    {
        $this->assertSame($this->request->setNewPassword('asdfgh!@#'), $this->request);
    }

    public function testNewPasswordGetter(): void
    {
        $this->request->setNewPassword('asdfgh!@#');

        $this->assertSame('asdfgh!@#', $this->request->getNewPassword());
    }

    public function testNewPasswordGetterWithoutSetter(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->request->getNewPassword();
    }

    public function testEnvelope(): void
    {
        $this->request->setSessionId('12345678');
        $this->request->setToken('qwertyuiop');
        $this->request->setDomain('01');
        $this->request->setLogin('TEST1');
        $this->request->setOldPassword('qwerty!@#');
        $this->request->setNewPassword('asdfgh!@#');
        $this->request->setOperatorId('12345');
        $this->request->setOperatorType(OperatorType::PROVIDER);

        $xml = $this->xmlRequest('ChangePasswordRequest.xml');

        $this->assertSame($xml, $this->request->toXml());
    }
}
