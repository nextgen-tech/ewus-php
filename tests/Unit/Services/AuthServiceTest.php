<?php
declare(strict_types=1);

namespace Tests\Unit\Services;

use NGT\Ewus\Services\AuthService;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    /**
     * The service instance.
     *
     * @var  \NGT\Ewus\Services\AuthService
     */
    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new AuthService();
    }

    public function testProductionUrl(): void
    {
        $this->assertSame(
            'https://ewus.nfz.gov.pl/ws-broker-server-ewus/services/Auth',
            $this->service->getProductionUrl()
        );
    }

    public function testSandboxUrl(): void
    {
        $this->assertSame(
            'https://ewus.nfz.gov.pl/ws-broker-server-ewus-auth-test/services/Auth',
            $this->service->getSandboxUrl()
        );
    }
}
