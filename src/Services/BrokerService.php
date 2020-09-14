<?php
declare(strict_types=1);

namespace Etermed\Ewus\Services;

use Etermed\Ewus\Contracts\Service;

class BrokerService implements Service
{
    /**
     * @inheritDoc
     */
    public function getProductionUrl(): string
    {
        return 'https://ewus.nfz.gov.pl/ws-broker-server-ewus/services/ServiceBroker?wsdl';
    }

    /**
     * @inheritDoc
     */
    public function getSandboxUrl(): string
    {
        return 'https://ewus.nfz.gov.pl/ws-broker-server-ewus-auth-test/services/ServiceBroker?wsdl';
    }
}
