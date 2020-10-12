<?php
declare(strict_types=1);

namespace Tests\Unit\Parsers;

use InvalidArgumentException;
use NGT\Ewus\Parsers\LoginParser;
use NGT\Ewus\Support\Xml;
use Tests\Support\TestRequest;
use Tests\TestCase;

class LoginParserTest extends TestCase
{
    /**
     * The parser instance.
     *
     * @var  \NGT\Ewus\Parsers\LoginParser
     */
    private $parser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = new LoginParser(new TestRequest());
    }

    public function testParser(): void
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:com="http://xml.kamsoft.pl/ws/common" xmlns:auth="http://xml.kamsoft.pl/ws/kaas/login_types">
    <soapenv:Body>
        <com:session id="1234567890"></com:session>
        <com:authToken id="TOKEN"></com:authToken>
        <auth:loginReturn>[000] Login message</auth:loginReturn>
    </soapenv:Body>
</soapenv:Envelope>
XML;

        $xml = new Xml($xml);

        /** @var \NGT\Ewus\Responses\LoginResponse */
        $response = $this->parser->parse($xml);

        $this->assertSame('1234567890', $response->getSessionId());
        $this->assertSame('TOKEN', $response->getToken());
        $this->assertSame('000', $response->getLoginCode());
        $this->assertSame('Login message', $response->getLoginMessage());
    }

    public function testMissingSessionId(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:com="http://xml.kamsoft.pl/ws/common" xmlns:auth="http://xml.kamsoft.pl/ws/kaas/login_types">
    <soapenv:Body>
        <com:authToken id="TOKEN"></com:authToken>
        <auth:loginReturn>[000] Login message</auth:loginReturn>
    </soapenv:Body>
</soapenv:Envelope>
XML;

        $xml = new Xml($xml);

        $this->parser->parse($xml);
    }

    public function testMissingToken(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:com="http://xml.kamsoft.pl/ws/common" xmlns:auth="http://xml.kamsoft.pl/ws/kaas/login_types">
    <soapenv:Body>
        <com:session id="1234567890"></com:session>
        <auth:loginReturn>[000] Login message</auth:loginReturn>
    </soapenv:Body>
</soapenv:Envelope>
XML;

        $xml = new Xml($xml);

        $this->parser->parse($xml);
    }

    public function testMissingLoginReturn(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:com="http://xml.kamsoft.pl/ws/common" xmlns:auth="http://xml.kamsoft.pl/ws/kaas/login_types">
    <soapenv:Body>
        <com:session id="1234567890"></com:session>
        <com:authToken id="TOKEN"></com:authToken>
    </soapenv:Body>
</soapenv:Envelope>
XML;

        $xml = new Xml($xml);

        $this->parser->parse($xml);
    }

    public function testInvalidLoginReturn(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:com="http://xml.kamsoft.pl/ws/common" xmlns:auth="http://xml.kamsoft.pl/ws/kaas/login_types">
    <soapenv:Body>
        <com:session id="1234567890"></com:session>
        <com:authToken id="TOKEN"></com:authToken>
        <auth:loginReturn>Login message</auth:loginReturn>
    </soapenv:Body>
</soapenv:Envelope>
XML;

        $xml = new Xml($xml);

        $this->parser->parse($xml);
    }
}
