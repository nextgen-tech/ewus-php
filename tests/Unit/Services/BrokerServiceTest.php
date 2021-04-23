<?php
declare(strict_types=1);

namespace Tests\Unit\Services;

use NGT\Ewus\Services\BrokerService;
use Tests\TestCase;

class BrokerServiceTest extends TestCase
{
    /**
     * The service instance.
     *
     * @var  \NGT\Ewus\Services\BrokerService
     */
    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new BrokerService();
    }

    public function testProductionUrl(): void
    {
        $this->assertSame(
            'https://ewus.nfz.gov.pl/ws-broker-server-ewus/services/ServiceBroker',
            $this->service->getProductionUrl()
        );
    }

    public function testSandboxUrl(): void
    {
        $this->assertSame(
            'https://ewus.nfz.gov.pl/ws-broker-server-ewus-auth-test/services/ServiceBroker',
            $this->service->getSandboxUrl()
        );
    }
}
