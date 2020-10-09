<?php

namespace Tests\Feature;

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

        $this->assertSame(1, $response->getStatus());
        $this->assertSame(1, $response->getInsuranceStatus());
        $this->assertEmpty($response->getPatientNotes());
    }

    public function testCheckInsuredWithQuarantine(): void
    {
        $response = $this->check('00032948271');

        $this->assertSame(1, $response->getStatus());
        $this->assertSame(1, $response->getInsuranceStatus());

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

        $this->assertSame(1, $response->getStatus());
        $this->assertSame(1, $response->getInsuranceStatus());

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

        $this->assertSame(1, $response->getStatus());
        $this->assertSame(0, $response->getInsuranceStatus());
        $this->assertEmpty($response->getPatientNotes());
    }

    public function testCheckUninsuredWithQuarantine(): void
    {
        $response = $this->check('00071274234');

        $this->assertSame(1, $response->getStatus());
        $this->assertSame(0, $response->getInsuranceStatus());

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

        $this->assertSame(1, $response->getStatus());
        $this->assertSame(0, $response->getInsuranceStatus());

        $notes = $response->getPatientNotes();
        $note  = $notes[0];

        $this->assertSame('IZOLACJA DOMOWA', $note['code']);
        $this->assertSame('O', $note['level']);
        $this->assertMatchesRegularExpression(
            '/^Pacjent podlega izolacji domowej do dnia \d{2}\-\d{2}\-\d{4}$/',
            $note['value']
        );
    }

    /**
     * @todo Issue #2
     * @link https://github.com/nextgen-tech/ewus-php/issues/2
     */
    public function testCheckUnlisted(): void
    {
        $response = $this->check('01010153201');

        $this->assertSame(0, $response->getStatus());
        // $this->assertSame(null, $response->getInsuranceStatus());
        $this->assertEmpty($response->getPatientNotes());
    }

    /**
     * @todo Issue #2
     * @link https://github.com/nextgen-tech/ewus-php/issues/2
     */
    public function testCheckCancelled(): void
    {
        $response = $this->check('00060958187');

        $this->assertSame(-1, $response->getStatus());
        // $this->assertSame(null, $response->getInsuranceStatus());
        $this->assertEmpty($response->getPatientNotes());
    }
}
