<?php
declare(strict_types=1);

namespace Tests\Unit\Parsers;

use NGT\Ewus\Parsers\ChangePasswordParser;
use NGT\Ewus\Support\Xml;
use Tests\Support\TestRequest;
use Tests\TestCase;

class ChangePasswordParserTest extends TestCase
{
    /**
     * The parser instance.
     *
     * @var  \NGT\Ewus\Parsers\ChangePasswordParser
     */
    private $parser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = new ChangePasswordParser(new TestRequest());
    }

    public function testParser(): void
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:auth="http://xml.kamsoft.pl/ws/kaas/login_types">
    <soapenv:Body>
        <auth:changePasswordReturn>Change password message</auth:changePasswordReturn>
    </soapenv:Body>
</soapenv:Envelope>
XML;

        $xml = new Xml($xml);

        /** @var \NGT\Ewus\Responses\ChangePasswordResponse */
        $response = $this->parser->parse($xml);

        $this->assertSame('Change password message', $response->getChangePasswordMessage());
    }
}
