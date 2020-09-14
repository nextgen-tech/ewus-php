<?php
declare(strict_types=1);

namespace Etermed\Ewus\Contracts;

interface Connection
{
    /**
     * Set the connection service.
     *
     * @param  \Etermed\Ewus\Contracts\Service  $service
     * @param  bool  $sandboxMode
     */
    public function setService(Service $service); // @phpstan-ignore-line

    /**
     * Set whether the connection is in sandbox mode or not.
     *
     * @param  bool  $sandboxMode
     */
    public function setSandboxMode(bool $sandboxMode); // @phpstan-ignore-line

    /**
     * Send data.
     *
     * @param   string  $data
     * @return  string
     */
    public function send(string $data): string;
}
