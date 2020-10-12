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

    public function testOperationDateSetter(): void
    {
        $this->assertSame($this->response->setOperationDate($this->mockOperationDate()), $this->response);
    }

    public function testOperationDateGetter(): void
    {
        $this->response->setOperationDate($this->mockOperationDate());

        /** @var DateTimeInterface */
        $operationDate = $this->response->getOperationDate();
        $this->assertSame('2020-01-01 00:00:00', $operationDate->format('Y-m-d H:i:s'));
    }

    public function testOperationIdSetter(): void
    {
        $this->assertSame($this->response->setOperationId('test'), $this->response);
    }

    public function testOperationIdGetter(): void
    {
        $this->response->setOperationId('test');
        $this->assertSame('test', $this->response->getOperationId());
    }

    public function testSystemNameSetter(): void
    {
        $this->assertSame($this->response->setSystemName('test'), $this->response);
    }

    public function testSystemNameGetter(): void
    {
        $this->response->setSystemName('test');
        $this->assertSame('test', $this->response->getSystemName());
    }

    public function testSystemVersionSetter(): void
    {
        $this->assertSame($this->response->setSystemVersion('1.2.3'), $this->response);
    }

    public function testSystemVersionGetter(): void
    {
        $this->response->setSystemVersion('1.2.3');
        $this->assertSame('1.2.3', $this->response->getSystemVersion());
    }

    public function testStatusSetter(): void
    {
        $this->assertSame($this->response->setStatus(1), $this->response);
    }

    public function testStatusGetter(): void
    {
        $this->response->setStatus(1);
        $this->assertSame(1, $this->response->getStatus());
    }

    public function testOperatorIdSetter(): void
    {
        $this->assertSame($this->response->setOperatorId('12345'), $this->response);
    }

    public function testOperatorIdGetter(): void
    {
        $this->response->setOperatorId('12345');
        $this->assertSame('12345', $this->response->getOperatorId());
    }

    public function testOperatorDomainSetter(): void
    {
        $this->assertSame($this->response->setOperatorDomain('01'), $this->response);
    }

    public function testOperatorDomainGetter(): void
    {
        $this->response->setOperatorDomain('01');
        $this->assertSame('01', $this->response->getOperatorDomain());
    }

    public function testOperatorExternalIdSetter(): void
    {
        $this->assertSame($this->response->setOperatorExternalId('12345'), $this->response);
    }

    public function testOperatorExternalIdGetter(): void
    {
        $this->response->setOperatorExternalId('12345');
        $this->assertSame('12345', $this->response->getOperatorExternalId());
    }

    public function testExpirationDateSetter(): void
    {
        $this->assertSame($this->response->setExpirationDate($this->mockExpirationDate()), $this->response);
    }

    public function testExpirationDateGetter(): void
    {
        $this->response->setExpirationDate($this->mockExpirationDate());

        /** @var DateTimeInterface */
        $expirationDate = $this->response->getExpirationDate();
        $this->assertSame('2020-01-01 23:59:59', $expirationDate->format('Y-m-d H:i:s'));
    }

    public function testInsuranceStatusSetter(): void
    {
        $this->assertSame($this->response->setInsuranceStatus(0), $this->response);
    }

    public function testInsuranceStatusGetter(): void
    {
        $this->response->setInsuranceStatus(0);
        $this->assertSame(0, $this->response->getInsuranceStatus());
    }

    public function testPrescriptionSymbolSetter(): void
    {
        $this->assertSame($this->response->setPrescriptionSymbol('DN'), $this->response);
    }

    public function testPrescriptionSymbolGetter(): void
    {
        $this->response->setPrescriptionSymbol('DN');
        $this->assertSame('DN', $this->response->getPrescriptionSymbol());
    }

    public function testPatientPeselSetter(): void
    {
        $this->assertSame($this->response->setPatientPesel('12345678901'), $this->response);
    }

    public function testPatientPeselGetter(): void
    {
        $this->response->setPatientPesel('12345678901');
        $this->assertSame('12345678901', $this->response->getPatientPesel());
    }

    public function testPatientFirstNameSetter(): void
    {
        $this->assertSame($this->response->setPatientFirstName('John'), $this->response);
    }

    public function testPatientFirstNameGetter(): void
    {
        $this->response->setPatientFirstName('John');
        $this->assertSame('John', $this->response->getPatientFirstName());
    }

    public function testPatientLastNameSetter(): void
    {
        $this->assertSame($this->response->setPatientLastName('Doe'), $this->response);
    }

    public function testPatientLastNameGetter(): void
    {
        $this->response->setPatientLastName('Doe');
        $this->assertSame('Doe', $this->response->getPatientLastName());
    }

    public function testPatientNotesSetter(): void
    {
        $this->assertSame($this->response->setPatientNotes([
            ['foo'],
        ]), $this->response);
    }

    public function testPatientNotesGetter(): void
    {
        $array = [
            ['foo'],
        ];

        $this->response->setPatientNotes($array);
        $this->assertSame($array, $this->response->getPatientNotes());
    }
}
