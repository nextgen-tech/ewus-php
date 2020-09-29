<?php
declare(strict_types=1);

namespace NGT\Ewus\Connections;

use NGT\Ewus\Contracts\Connection as ConnectionContract;
use SoapClient;

class SoapConnection extends Connection implements ConnectionContract
{
    /**
     * The SOAP clients instances.
     *
     * @var  SoapClient[]
     */
    protected $clients = [];

    /**
     * Get the SOAP client for current service.
     *
     * @return  SoapClient
     */
    public function getClient(): SoapClient
    {
        $hash = spl_object_hash($this->service);

        if (!array_key_exists($hash, $this->clients)) {
            $this->clients[$hash] = new SoapClient($this->getServiceUrl());
        }

        return $this->clients[$hash];
    }

    /**
     * @inheritDoc
     */
    public function send(string $data): string
    {
        return $this->getClient()->__doRequest($data, $this->getServiceUrl(), 'executeService', SOAP_1_1);
    }
}
