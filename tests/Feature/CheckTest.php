<?php

namespace Tests\Feature;

use DateTime;
use DateTimeInterface;
use NGT\Ewus\Connections\HttpConnection;
use NGT\Ewus\Enums\OperatorType;
use NGT\Ewus\Handler;
use NGT\Ewus\Requests\CheckRequest;
use NGT\Ewus\Requests\LoginRequest;
use NGT\Ewus\Requests\LogoutRequest;
use NGT\Ewus\Responses\CheckResponse;
use Tests\TestCase;

class CheckTest extends TestCase
{
    /**
     * The handler instance.
     *
     * @var  \NGT\Ewus\Handler
     */
    private static $handler;

    /**
     * The login response instance.
     *
     * @var  \NGT\Ewus\Responses\LoginResponse
     */
    private static $login;

    public static function setUpBeforeClass(): void
    {
        self::$handler = new Handler();
        self::$handler->setConnection(new HttpConnection());
        self::$handler->enableSandboxMode();

        /** @var \NGT\Ewus\Responses\LoginResponse */
        $response = self::$handler->handle(
            new LoginRequest('01', 'TEST', 'qwerty!@#', '123456789', OperatorType::PROVIDER)
        );

        self::$login = $response;
    }

    public static function tearDownAfterClass(): void
    {
        $request = new LogoutRequest(self::$login->getSessionId(), self::$login->getToken());

        self::$handler->handle($request);
    }

    private function check(string $pesel): CheckResponse
    {
        $request = new CheckRequest();
        $request->setSessionId(self::$login->getSessionId());
        $request->setToken(self::$login->getToken());
        $request->setPesel($pesel);

        /** @var \NGT\Ewus\Responses\CheckResponse */
        return self::$handler->handle($request);
    }

    public function testCheckInsuredWithoutNotes(): void
    {
        $response = $this->check('79060804378');

        /** @var string */
        $operationId = $response->getOperationId();

        $expectedExpirationDate = (new DateTime('now'))->setTime(23, 59, 59);
        /** @var DateTimeInterface */
        $expirationDate = $response->getExpirationDate();

        $this->assertInstanceOf(DateTimeInterface::class, $response->getOperationDate());
        $this->assertMatchesRegularExpression('/^L\d{4}M\d{11}$/', $operationId);
        $this->assertSame('eWUS', $response->getSystemName());
        $this->assertSame('test', $response->getSystemVersion());
        $this->assertSame(1, $response->getStatus());
        $this->assertSame('3', $response->getOperatorId());
        $this->assertSame('01', $response->getOperatorDomain());
        $this->assertSame('TEST3', $response->getOperatorExternalId());
        $this->assertSame($expectedExpirationDate->format('Y-m-d H:i:s'), $expirationDate->format('Y-m-d H:i:s'));
        $this->assertSame(1, $response->getInsuranceStatus());
        $this->assertSame('', $response->getPrescriptionSymbol());
        $this->assertSame('79060804378', $response->getPatientPesel());
        $this->assertSame('ImięTAK=2', $response->getPatientFirstName());
        $this->assertSame('NazwiskoTAK', $response->getPatientLastName());
        $this->assertEmpty($response->getPatientNotes());
    }

    public function testCheckInsuredWithVaccine(): void
    {
        $response = $this->check('00081314722');

        /** @var string */
        $operationId = $response->getOperationId();

        $expectedExpirationDate = (new DateTime('now'))->setTime(23, 59, 59);
        /** @var DateTimeInterface */
        $expirationDate = $response->getExpirationDate();

        $this->assertInstanceOf(DateTimeInterface::class, $response->getOperationDate());
        $this->assertMatchesRegularExpression('/^L\d{4}M\d{11}$/', $operationId);
        $this->assertSame('eWUS', $response->getSystemName());
        $this->assertSame('test', $response->getSystemVersion());
        $this->assertSame(1, $response->getStatus());
        $this->assertSame('3', $response->getOperatorId());
        $this->assertSame('01', $response->getOperatorDomain());
        $this->assertSame('TEST3', $response->getOperatorExternalId());
        $this->assertSame($expectedExpirationDate->format('Y-m-d H:i:s'), $expirationDate->format('Y-m-d H:i:s'));
        $this->assertSame(1, $response->getInsuranceStatus());
        $this->assertSame('', $response->getPrescriptionSymbol());
        $this->assertSame('00081314722', $response->getPatientPesel());
        $this->assertSame('ImięTAK', $response->getPatientFirstName());
        $this->assertSame('NazwiskoTAK', $response->getPatientLastName());

        $notes = $response->getPatientNotes();
        $note  = $notes[0];

        $this->assertSame('ZASWIADCZENIE-COVID', $note['code']);
        $this->assertSame('I', $note['level']);
        $this->assertMatchesRegularExpression(
            '/^Pacjentowi wystawiono zaświadczenie o szczepieniu dnia: \d{2}\-\d{2}\-\d{4}$/',
            $note['value']
        );
    }

    public function testCheckInsuredWithQuarantine(): void
    {
        $response = $this->check('00032948271');

        /** @var string */
        $operationId = $response->getOperationId();

        $expectedExpirationDate = (new DateTime('now'))->setTime(23, 59, 59);
        /** @var DateTimeInterface */
        $expirationDate = $response->getExpirationDate();

        $this->assertInstanceOf(DateTimeInterface::class, $response->getOperationDate());
        $this->assertMatchesRegularExpression('/^L\d{4}M\d{11}$/', $operationId);
        $this->assertSame('eWUS', $response->getSystemName());
        $this->assertSame('test', $response->getSystemVersion());
        $this->assertSame(1, $response->getStatus());
        $this->assertSame('3', $response->getOperatorId());
        $this->assertSame('01', $response->getOperatorDomain());
        $this->assertSame('TEST3', $response->getOperatorExternalId());
        $this->assertSame($expectedExpirationDate->format('Y-m-d H:i:s'), $expirationDate->format('Y-m-d H:i:s'));
        $this->assertSame(1, $response->getInsuranceStatus());
        $this->assertSame('', $response->getPrescriptionSymbol());
        $this->assertSame('00032948271', $response->getPatientPesel());
        $this->assertSame('ImięTAK', $response->getPatientFirstName());
        $this->assertSame('NazwiskoTAK', $response->getPatientLastName());

        $notes = $response->getPatientNotes();
        $note  = $notes[0];

        $this->assertSame('KWARANTANNA-COVID19', $note['code']);
        $this->assertSame('O', $note['level']);
        $this->assertMatchesRegularExpression(
            '/^Pacjent objęty kwarantanną do dnia \d{2}\-\d{2}\-\d{4}$/',
            $note['value']
        );
    }

    public function testCheckInsuredWithIsolation(): void
    {
        $response = $this->check('00102721595');

        /** @var string */
        $operationId = $response->getOperationId();

        $expectedExpirationDate = (new DateTime('now'))->setTime(23, 59, 59);
        /** @var DateTimeInterface */
        $expirationDate = $response->getExpirationDate();

        $this->assertInstanceOf(DateTimeInterface::class, $response->getOperationDate());
        $this->assertMatchesRegularExpression('/^L\d{4}M\d{11}$/', $operationId);
        $this->assertSame('eWUS', $response->getSystemName());
        $this->assertSame('test', $response->getSystemVersion());
        $this->assertSame(1, $response->getStatus());
        $this->assertSame('3', $response->getOperatorId());
        $this->assertSame('01', $response->getOperatorDomain());
        $this->assertSame('TEST3', $response->getOperatorExternalId());
        $this->assertSame($expectedExpirationDate->format('Y-m-d H:i:s'), $expirationDate->format('Y-m-d H:i:s'));
        $this->assertSame(1, $response->getInsuranceStatus());
        $this->assertSame('', $response->getPrescriptionSymbol());
        $this->assertSame('00102721595', $response->getPatientPesel());
        $this->assertSame('ImięTAK', $response->getPatientFirstName());
        $this->assertSame('NazwiskoTAK', $response->getPatientLastName());

        $notes = $response->getPatientNotes();
        $note  = $notes[0];

        $this->assertSame('IZOLACJA DOMOWA', $note['code']);
        $this->assertSame('O', $note['level']);
        $this->assertMatchesRegularExpression(
            '/^Pacjent podlega izolacji domowej do dnia \d{2}\-\d{2}\-\d{4}$/',
            $note['value']
        );
    }

    public function testCheckUninsuredWithoutNotes(): void
    {
        $response = $this->check('55021562501');

        /** @var string */
        $operationId = $response->getOperationId();

        $expectedExpirationDate = (new DateTime('now'))->setTime(23, 59, 59);
        /** @var DateTimeInterface */
        $expirationDate = $response->getExpirationDate();

        $this->assertInstanceOf(DateTimeInterface::class, $response->getOperationDate());
        $this->assertMatchesRegularExpression('/^L\d{4}M\d{11}$/', $operationId);
        $this->assertSame('eWUS', $response->getSystemName());
        $this->assertSame('test', $response->getSystemVersion());
        $this->assertSame(1, $response->getStatus());
        $this->assertSame('3', $response->getOperatorId());
        $this->assertSame('01', $response->getOperatorDomain());
        $this->assertSame('TEST3', $response->getOperatorExternalId());
        $this->assertSame($expectedExpirationDate->format('Y-m-d H:i:s'), $expirationDate->format('Y-m-d H:i:s'));
        $this->assertSame(0, $response->getInsuranceStatus());
        $this->assertSame('', $response->getPrescriptionSymbol());
        $this->assertSame('55021562501', $response->getPatientPesel());
        $this->assertSame('ImięNIE', $response->getPatientFirstName());
        $this->assertSame('NazwiskoNIE', $response->getPatientLastName());
        $this->assertEmpty($response->getPatientNotes());
    }

    public function testCheckUninsuredWithVaccine(): void
    {
        $response = $this->check('00021459812');

        /** @var string */
        $operationId = $response->getOperationId();

        $expectedExpirationDate = (new DateTime('now'))->setTime(23, 59, 59);
        /** @var DateTimeInterface */
        $expirationDate = $response->getExpirationDate();

        $this->assertInstanceOf(DateTimeInterface::class, $response->getOperationDate());
        $this->assertMatchesRegularExpression('/^L\d{4}M\d{11}$/', $operationId);
        $this->assertSame('eWUS', $response->getSystemName());
        $this->assertSame('test', $response->getSystemVersion());
        $this->assertSame(1, $response->getStatus());
        $this->assertSame('3', $response->getOperatorId());
        $this->assertSame('01', $response->getOperatorDomain());
        $this->assertSame('TEST3', $response->getOperatorExternalId());
        $this->assertSame($expectedExpirationDate->format('Y-m-d H:i:s'), $expirationDate->format('Y-m-d H:i:s'));
        $this->assertSame(0, $response->getInsuranceStatus());
        $this->assertSame('', $response->getPrescriptionSymbol());
        $this->assertSame('00021459812', $response->getPatientPesel());
        $this->assertSame('ImięNIE', $response->getPatientFirstName());
        $this->assertSame('NazwiskoNIE', $response->getPatientLastName());

        $notes = $response->getPatientNotes();
        $note  = $notes[0];

        $this->assertSame('ZASWIADCZENIE-COVID', $note['code']);
        $this->assertSame('I', $note['level']);
        $this->assertMatchesRegularExpression(
            '/^Pacjentowi wystawiono zaświadczenie o szczepieniu dnia: \d{2}\-\d{2}\-\d{4}$/',
            $note['value']
        );
    }

    public function testCheckUninsuredWithQuarantine(): void
    {
        $response = $this->check('00071274234');

        /** @var string */
        $operationId = $response->getOperationId();

        $expectedExpirationDate = (new DateTime('now'))->setTime(23, 59, 59);
        /** @var DateTimeInterface */
        $expirationDate = $response->getExpirationDate();

        $this->assertInstanceOf(DateTimeInterface::class, $response->getOperationDate());
        $this->assertMatchesRegularExpression('/^L\d{4}M\d{11}$/', $operationId);
        $this->assertSame('eWUS', $response->getSystemName());
        $this->assertSame('test', $response->getSystemVersion());
        $this->assertSame(1, $response->getStatus());
        $this->assertSame('3', $response->getOperatorId());
        $this->assertSame('01', $response->getOperatorDomain());
        $this->assertSame('TEST3', $response->getOperatorExternalId());
        $this->assertSame($expectedExpirationDate->format('Y-m-d H:i:s'), $expirationDate->format('Y-m-d H:i:s'));
        $this->assertSame(0, $response->getInsuranceStatus());
        $this->assertSame('', $response->getPrescriptionSymbol());
        $this->assertSame('00071274234', $response->getPatientPesel());
        $this->assertSame('ImięNIE', $response->getPatientFirstName());
        $this->assertSame('NazwiskoNIE', $response->getPatientLastName());

        $notes = $response->getPatientNotes();
        $note  = $notes[0];

        $this->assertSame('KWARANTANNA-COVID19', $note['code']);
        $this->assertSame('O', $note['level']);
        $this->assertMatchesRegularExpression(
            '/^Pacjent objęty kwarantanną do dnia \d{2}\-\d{2}\-\d{4}$/',
            $note['value']
        );
    }

    public function testCheckUninsuredWithIsolation(): void
    {
        $response = $this->check('00092497177');

        /** @var string */
        $operationId = $response->getOperationId();

        $expectedExpirationDate = (new DateTime('now'))->setTime(23, 59, 59);
        /** @var DateTimeInterface */
        $expirationDate = $response->getExpirationDate();

        $this->assertInstanceOf(DateTimeInterface::class, $response->getOperationDate());
        $this->assertMatchesRegularExpression('/^L\d{4}M\d{11}$/', $operationId);
        $this->assertSame('eWUS', $response->getSystemName());
        $this->assertSame('test', $response->getSystemVersion());
        $this->assertSame(1, $response->getStatus());
        $this->assertSame('3', $response->getOperatorId());
        $this->assertSame('01', $response->getOperatorDomain());
        $this->assertSame('TEST3', $response->getOperatorExternalId());
        $this->assertSame($expectedExpirationDate->format('Y-m-d H:i:s'), $expirationDate->format('Y-m-d H:i:s'));
        $this->assertSame(0, $response->getInsuranceStatus());
        $this->assertSame('', $response->getPrescriptionSymbol());
        $this->assertSame('00092497177', $response->getPatientPesel());
        $this->assertSame('ImięNIE', $response->getPatientFirstName());
        $this->assertSame('NazwiskoNIE', $response->getPatientLastName());

        $notes = $response->getPatientNotes();
        $note  = $notes[0];

        $this->assertSame('IZOLACJA DOMOWA', $note['code']);
        $this->assertSame('O', $note['level']);
        $this->assertMatchesRegularExpression(
            '/^Pacjent podlega izolacji domowej do dnia \d{2}\-\d{2}\-\d{4}$/',
            $note['value']
        );
    }

    public function testCheckUnlisted(): void
    {
        $response = $this->check('01010153201');

        /** @var string */
        $operationId = $response->getOperationId();

        $this->assertInstanceOf(DateTimeInterface::class, $response->getOperationDate());
        $this->assertMatchesRegularExpression('/^L\d{4}M\d{11}$/', $operationId);
        $this->assertSame('eWUS', $response->getSystemName());
        $this->assertSame('test', $response->getSystemVersion());
        $this->assertSame(0, $response->getStatus());
        $this->assertSame('3', $response->getOperatorId());
        $this->assertSame('01', $response->getOperatorDomain());
        $this->assertSame('TEST3', $response->getOperatorExternalId());
        $this->assertNull($response->getExpirationDate());
        $this->assertNull($response->getInsuranceStatus());
        $this->assertNull($response->getPrescriptionSymbol());
        $this->assertSame('01010153201', $response->getPatientPesel());
        $this->assertNull($response->getPatientFirstName());
        $this->assertNull($response->getPatientLastName());
        $this->assertEmpty($response->getPatientNotes());
    }

    public function testCheckCancelled(): void
    {
        $response = $this->check('00060958187');

        /** @var string */
        $operationId = $response->getOperationId();

        $this->assertInstanceOf(DateTimeInterface::class, $response->getOperationDate());
        $this->assertMatchesRegularExpression('/^L\d{4}M\d{11}$/', $operationId);
        $this->assertSame('eWUS', $response->getSystemName());
        $this->assertSame('test', $response->getSystemVersion());
        $this->assertSame(-1, $response->getStatus());
        $this->assertSame('3', $response->getOperatorId());
        $this->assertSame('01', $response->getOperatorDomain());
        $this->assertSame('TEST3', $response->getOperatorExternalId());
        $this->assertNull($response->getExpirationDate());
        $this->assertNull($response->getInsuranceStatus());
        $this->assertNull($response->getPrescriptionSymbol());
        $this->assertSame('00060958187', $response->getPatientPesel());
        $this->assertNull($response->getPatientFirstName());
        $this->assertNull($response->getPatientLastName());
        $this->assertEmpty($response->getPatientNotes());
    }
}
