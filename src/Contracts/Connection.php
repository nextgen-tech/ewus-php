<?php
declare(strict_types=1);

namespace Etermed\Ewus\Contracts;

interface Connection
{
    /**
     * Set the connection service.
     *
     * @param  \Etermed\Ewus\Contracts\Service  $service
     */
    public function setService(Service $service): self;

    /**
     * Set whether the connection is in sandbox mode or not.
     *
     * @param  bool  $sandboxMode
     */
    public function setSandboxMode(bool $sandboxMode): self;

    /**
     * Send data.
     *
     * @param   string  $data
     * @return  string
     */
    public function send(string $data): string;
}
