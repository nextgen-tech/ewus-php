<?php
declare(strict_types=1);

namespace Tests\Unit\Parsers;

use DateTime;
use NGT\Ewus\Parsers\CheckParser;
use NGT\Ewus\Support\Xml;
use Tests\Support\TestRequest;
use Tests\TestCase;

class CheckParserTest extends TestCase
{
    /**
     * The parser instance.
     *
     * @var  \NGT\Ewus\Parsers\CheckParser
     */
    private $parser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = new CheckParser(new TestRequest());
    }

    public function testParserForEmptyXml(): void
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ewus="https://ewus.nfz.gov.pl/ws/broker/ewus/status_cwu/v5">
    <soapenv:Body></soapenv:Body>
</soapenv:Envelope>
XML;

        $xml = new Xml($xml);

        /** @var \NGT\Ewus\Responses\CheckResponse */
        $response = $this->parser->parse($xml);

        $this->assertNull($response->getOperationDate());
        $this->assertNull($response->getOperationId());
        $this->assertNull($response->getSystemName());
        $this->assertNull($response->getSystemVersion());
        $this->assertNull($response->getStatus());
        $this->assertNull($response->getOperatorId());
        $this->assertNull($response->getOperatorDomain());
        $this->assertNull($response->getOperatorExternalId());
        $this->assertNull($response->getExpirationDate());
        $this->assertNull($response->getInsuranceStatus());
        $this->assertNull($response->getPrescriptionSymbol());
        $this->assertNull($response->getPatientPesel());
        $this->assertNull($response->getPatientFirstName());
        $this->assertNull($response->getPatientLastName());
        $this->assertEmpty($response->getPatientNotes());
    }

    public function testParser(): void
    {
        $xml = <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ewus="https://ewus.nfz.gov.pl/ws/broker/ewus/status_cwu/v5">
    <soapenv:Body>
        <ewus:status_cwu_odp data_czas_operacji="2020-01-01 00:00:00" id_operacji="12345"></ewus:status_cwu_odp>
        <ewus:system_nfz nazwa="eWUS" wersja="test"></ewus:system_nfz>
        <ewus:status_cwu>1</ewus:status_cwu>
        <ewus:id_operatora>1234</ewus:id_operatora>
        <ewus:id_ow>01</ewus:id_ow>
        <ewus:id_swiad>12345678</ewus:id_swiad>
        <ewus:data_waznosci_potwierdzenia>2020-01-01 12:00:00</ewus:data_waznosci_potwierdzenia>
        <ewus:status_ubezp ozn_rec="DN">1</ewus:status_ubezp>
        <ewus:numer_pesel>12345678901</ewus:numer_pesel>
        <ewus:imie>Jan</ewus:imie>
        <ewus:nazwisko>Kowalski</ewus:nazwisko>
        <ewus:informacje_dodatkowe>
            <ewus:informacja kod="TEST" poziom="O" wartosc="Test message"></ewus:informacja>
        </ewus:informacje_dodatkowe>
    </soapenv:Body>
</soapenv:Envelope>
XML;

        $xml = new Xml($xml);

        /** @var \NGT\Ewus\Responses\CheckResponse */
        $response = $this->parser->parse($xml);

        $this->assertSame(
            (new DateTime('2020-01-01 00:00:00'))->format('Y-m-d H:i:s'),
            $response->getOperationDate() !== null ? $response->getOperationDate()->format('Y-m-d H:i:s') : null
        );
        $this->assertSame('12345', $response->getOperationId());
        $this->assertSame('eWUS', $response->getSystemName());
        $this->assertSame('test', $response->getSystemVersion());
        $this->assertSame(1, $response->getStatus());
        $this->assertSame('1234', $response->getOperatorId());
        $this->assertSame('01', $response->getOperatorDomain());
        $this->assertSame('12345678', $response->getOperatorExternalId());
        $this->assertSame(
            (new DateTime('2020-01-01 23:59:59'))->format('Y-m-d H:i:s'),
            $response->getExpirationDate() !== null ? $response->getExpirationDate()->format('Y-m-d H:i:s') : null
        );
        $this->assertSame(1, $response->getInsuranceStatus());
        $this->assertSame('DN', $response->getPrescriptionSymbol());
        $this->assertSame('12345678901', $response->getPatientPesel());
        $this->assertSame('Jan', $response->getPatientFirstName());
        $this->assertSame('Kowalski', $response->getPatientLastName());
        $this->assertSame([
            [
                'code'  => 'TEST',
                'level' => 'O',
                'value' => 'Test message',
            ],
        ], $response->getPatientNotes());
    }
}
