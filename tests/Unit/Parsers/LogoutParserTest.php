<?php
declare(strict_types=1);

namespace Tests\Unit\Parsers;

use NGT\Ewus\Parsers\LogoutParser;
use NGT\Ewus\Support\Xml;
use Tests\Support\TestRequest;
use Tests\TestCase;

class LogoutParserTest extends TestCase
{
    /**
     * The parser instance.
     *
     * @var  \NGT\Ewus\Parsers\LogoutParser
     */
    private $parser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = new LogoutParser(new TestRequest());
    }

    public function testParser(): void
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:auth="http://xml.kamsoft.pl/ws/kaas/login_types">
    <soapenv:Body>
        <auth:logoutReturn>Logout message</auth:logoutReturn>
    </soapenv:Body>
</soapenv:Envelope>
XML;

        $xml = new Xml($xml);

        /** @var \NGT\Ewus\Responses\LogoutResponse */
        $response = $this->parser->parse($xml);

        $this->assertSame('Logout message', $response->getLogoutMessage());
    }
}
