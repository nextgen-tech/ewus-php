<?php
declare(strict_types=1);

namespace NGT\Ewus\Connections;

use NGT\Ewus\Contracts\Connection as ConnectionContract;
use NGT\Ewus\Contracts\Service as ServiceContract;

abstract class Connection implements ConnectionContract
{
    /**
     * The connection configuration.
     *
     * @var  mixed[]
     */
    protected $config = [];

    /**
     * The connection service instance.
     *
     * @var  \NGT\Ewus\Contracts\Service
     */
    protected $service;

    /**
     * The sandbox mode indicator.
     *
     * @var  bool
     */
    protected $sandboxMode = false;

    /**
     * The connection constructor.
     *
     * @param  mixed[]  $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function setService(ServiceContract $service): ConnectionContract
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSandboxMode(bool $sandboxMode): ConnectionContract
    {
        $this->sandboxMode = $sandboxMode;

        return $this;
    }

    /**
     * Get the service URL.
     *
     * @return  string
     */
    public function getServiceUrl(): string
    {
        if ($this->sandboxMode === false) {
            return $this->service->getProductionUrl();
        }

        return $this->service->getSandboxUrl();
    }
}
