<?php
declare(strict_types=1);

namespace Tests\Unit\Responses;

use DateTime;
use DateTimeInterface;
use NGT\Ewus\Requests\CheckRequest;
use NGT\Ewus\Responses\CheckResponse;
use Tests\TestCase;

class CheckResponseTest extends TestCase
{
    /**
     * The response instance.
     *
     * @var  \NGT\Ewus\Responses\CheckResponse
     */
    private $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new CheckResponse(new CheckRequest(), '');
    }

    private function mockDate(string $date): DateTimeInterface
    {
        return new DateTime($date);
    }

    private function mockOperationDate(): DateTimeInterface
    {
        return $this->mockDate('2020-01-01 00:00:00');
    }

    private function mockExpirationDate(): DateTimeInterface
    {
        return $this->mockDate('2020-01-01 23:59:59');
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setOperationDate
     */
    public function testOperationDateSetter(): void
    {
        $this->assertSame($this->response->setOperationDate($this->mockOperationDate()), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getOperationDate
     */
    public function testOperationDateGetter(): void
    {
        $this->response->setOperationDate($this->mockOperationDate());
        $this->assertSame('2020-01-01 00:00:00', $this->response->getOperationDate()->format('Y-m-d H:i:s'));
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setOperationId
     */
    public function testOperationIdSetter(): void
    {
        $this->assertSame($this->response->setOperationId('test'), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getOperationId
     */
    public function testOperationIdGetter(): void
    {
        $this->response->setOperationId('test');
        $this->assertSame('test', $this->response->getOperationId());
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setSystemName
     */
    public function testSystemNameSetter(): void
    {
        $this->assertSame($this->response->setSystemName('test'), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getSystemName
     */
    public function testSystemNameGetter(): void
    {
        $this->response->setSystemName('test');
        $this->assertSame('test', $this->response->getSystemName());
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setSystemVersion
     */
    public function testSystemVersionSetter(): void
    {
        $this->assertSame($this->response->setSystemVersion('1.2.3'), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getSystemVersion
     */
    public function testSystemVersionGetter(): void
    {
        $this->response->setSystemVersion('1.2.3');
        $this->assertSame('1.2.3', $this->response->getSystemVersion());
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setStatus
     */
    public function testStatusSetter(): void
    {
        $this->assertSame($this->response->setStatus(1), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getStatus
     */
    public function testStatusGetter(): void
    {
        $this->response->setStatus(1);
        $this->assertSame(1, $this->response->getStatus());
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setOperatorId
     */
    public function testOperatorIdSetter(): void
    {
        $this->assertSame($this->response->setOperatorId('12345'), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getOperatorId
     */
    public function testOperatorIdGetter(): void
    {
        $this->response->setOperatorId('12345');
        $this->assertSame('12345', $this->response->getOperatorId());
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setOperatorDomain
     */
    public function testOperatorDomainSetter(): void
    {
        $this->assertSame($this->response->setOperatorDomain('01'), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getOperatorDomain
     */
    public function testOperatorDomainGetter(): void
    {
        $this->response->setOperatorDomain('01');
        $this->assertSame('01', $this->response->getOperatorDomain());
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setOperatorExternalId
     */
    public function testOperatorExternalIdSetter(): void
    {
        $this->assertSame($this->response->setOperatorExternalId('12345'), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getOperatorExternalId
     */
    public function testOperatorExternalIdGetter(): void
    {
        $this->response->setOperatorExternalId('12345');
        $this->assertSame('12345', $this->response->getOperatorExternalId());
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setExpirationDate
     */
    public function testExpirationDateSetter(): void
    {
        $this->assertSame($this->response->setExpirationDate($this->mockExpirationDate()), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getExpirationDate
     */
    public function testExpirationDateGetter(): void
    {
        $this->response->setExpirationDate($this->mockExpirationDate());
        $this->assertSame('2020-01-01 23:59:59', $this->response->getExpirationDate()->format('Y-m-d H:i:s'));
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setInsuranceStatus
     */
    public function testInsuranceStatusSetter(): void
    {
        $this->assertSame($this->response->setInsuranceStatus(0), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getInsuranceStatus
     */
    public function testInsuranceStatusGetter(): void
    {
        $this->response->setInsuranceStatus(0);
        $this->assertSame(0, $this->response->getInsuranceStatus());
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setPrescriptionSymbol
     */
    public function testPrescriptionSymbolSetter(): void
    {
        $this->assertSame($this->response->setPrescriptionSymbol('DN'), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getPrescriptionSymbol
     */
    public function testPrescriptionSymbolGetter(): void
    {
        $this->response->setPrescriptionSymbol('DN');
        $this->assertSame('DN', $this->response->getPrescriptionSymbol());
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setPatientPesel
     */
    public function testPatientPeselSetter(): void
    {
        $this->assertSame($this->response->setPatientPesel('12345678901'), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getPatientPesel
     */
    public function testPatientPeselGetter(): void
    {
        $this->response->setPatientPesel('12345678901');
        $this->assertSame('12345678901', $this->response->getPatientPesel());
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setPatientFirstName
     */
    public function testPatientFirstNameSetter(): void
    {
        $this->assertSame($this->response->setPatientFirstName('John'), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getPatientFirstName
     */
    public function testPatientFirstNameGetter(): void
    {
        $this->response->setPatientFirstName('John');
        $this->assertSame('John', $this->response->getPatientFirstName());
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setPatientLastName
     */
    public function testPatientLastNameSetter(): void
    {
        $this->assertSame($this->response->setPatientLastName('Doe'), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getPatientLastName
     */
    public function testPatientLastNameGetter(): void
    {
        $this->response->setPatientLastName('Doe');
        $this->assertSame('Doe', $this->response->getPatientLastName());
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::setPatientNotes
     */
    public function testPatientNotesSetter(): void
    {
        $this->assertSame($this->response->setPatientNotes([
            ['foo'],
        ]), $this->response);
    }

    /**
     * @covers \NGT\Ewus\Responses\CheckResponse::getPatientNotes
     */
    public function testPatientNotesGetter(): void
    {
        $array = [
            ['foo'],
        ];

        $this->response->setPatientNotes($array);
        $this->assertSame($array, $this->response->getPatientNotes());
    }
}
