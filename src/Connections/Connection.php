<?php
declare(strict_types=1);

namespace Etermed\Ewus\Connections;

use Etermed\Ewus\Contracts\Service as ServiceContract;

abstract class Connection
{
    /**
     * The connection service instance.
     *
     * @var  \Etermed\Ewus\Contracts\Service
     */
    protected $service;

    /**
     * The sandbox mode indicator.
     *
     * @var  bool
     */
    protected $sandboxMode = false;

    /**
     * @inheritDoc
     */
    public function setService(ServiceContract $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSandboxMode(bool $sandboxMode): self
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
