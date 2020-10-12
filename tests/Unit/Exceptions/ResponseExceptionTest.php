<?php
declare(strict_types=1);

namespace Tests\Unit\Exceptions;

use NGT\Ewus\Exceptions\ResponseException;
use NGT\Ewus\Support\Xml;
use Tests\TestCase;

class ResponseExcepitonTest extends TestCase
{
    public function testGetTypeMethod(): void
    {
        $exception = new ResponseException('Test message', 500, 'test-type');

        $this->assertSame('test-type', $exception->getType());
    }

    public function testDetailedError(): void
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Body>
        <soapenv:Fault xmlns:ns2="http://xml.kamsoft.pl/ws/common">
            <ns2:faultcode>Client.AuthenticationException</ns2:faultcode>
            <ns2:faultstring>Detailed error message.</ns2:faultstring>
        </soapenv:Fault>
    </soapenv:Body>
</soapenv:Envelope>
XML;
        $xml = new Xml($xml);

        $exception = ResponseException::fromXml($xml);

        $this->assertSame('Detailed error message.', $exception->getMessage());
        $this->assertSame(401, $exception->getCode());
        $this->assertSame('AuthenticationException', $exception->getType());
    }

    public function testGeneralError(): void
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Body>
        <faultcode>soapenv:Server</faultcode>
        <faultstring>General error message.</faultstring>
    </soapenv:Body>
</soapenv:Envelope>
XML;
        $xml = new Xml($xml);

        $exception = ResponseException::fromXml($xml);

        $this->assertSame('General error message.', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertSame('', $exception->getType());
    }

    public function testPreferringDetailedErrorOverGeneral(): void
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Body>
        <faultcode>soapenv:Server</faultcode>
        <faultstring>General error message.</faultstring>
        <soapenv:Fault xmlns:ns2="http://xml.kamsoft.pl/ws/common">
            <ns2:faultcode>Client.AuthenticationException</ns2:faultcode>
            <ns2:faultstring>Detailed error message.</ns2:faultstring>
        </soapenv:Fault>
    </soapenv:Body>
</soapenv:Envelope>
XML;
        $xml = new Xml($xml);

        $exception = ResponseException::fromXml($xml);

        $this->assertSame('Detailed error message.', $exception->getMessage());
        $this->assertSame(401, $exception->getCode());
        $this->assertSame('AuthenticationException', $exception->getType());
    }

    public function testServiceException(): void
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Body>
        <soapenv:Fault xmlns:ns2="http://xml.kamsoft.pl/ws/common">
            <ns2:faultcode>Client.ServiceException</ns2:faultcode>
            <ns2:faultstring>Test service error message.</ns2:faultstring>
        </soapenv:Fault>
    </soapenv:Body>
</soapenv:Envelope>
XML;
        $xml = new Xml($xml);

        $exception = ResponseException::fromXml($xml);

        $this->assertSame(503, $exception->getCode());
    }

    public function testServerException(): void
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Body>
        <soapenv:Fault xmlns:ns2="http://xml.kamsoft.pl/ws/common">
            <ns2:faultcode>Client.ServerException</ns2:faultcode>
            <ns2:faultstring>Test server error message.</ns2:faultstring>
        </soapenv:Fault>
    </soapenv:Body>
</soapenv:Envelope>
XML;
        $xml = new Xml($xml);

        $exception = ResponseException::fromXml($xml);

        $this->assertSame(500, $exception->getCode());
    }

    public function testInputException(): void
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Body>
        <soapenv:Fault xmlns:ns2="http://xml.kamsoft.pl/ws/common">
            <ns2:faultcode>Client.InputException</ns2:faultcode>
            <ns2:faultstring>Test input error message.</ns2:faultstring>
        </soapenv:Fault>
    </soapenv:Body>
</soapenv:Envelope>
XML;
        $xml = new Xml($xml);

        $exception = ResponseException::fromXml($xml);

        $this->assertSame(422, $exception->getCode());
    }

    public function testAuthorizationException(): void
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Body>
        <soapenv:Fault xmlns:ns2="http://xml.kamsoft.pl/ws/common">
            <ns2:faultcode>Client.AuthorizationException</ns2:faultcode>
            <ns2:faultstring>Test authorization error message.</ns2:faultstring>
        </soapenv:Fault>
    </soapenv:Body>
</soapenv:Envelope>
XML;
        $xml = new Xml($xml);

        $exception = ResponseException::fromXml($xml);

        $this->assertSame(403, $exception->getCode());
    }
}
