<?php
declare(strict_types=1);

namespace Etermed\Ewus\Contracts;

interface Service
{
    /**
     * Get production URL of service.
     *
     * @return  string
     */
    public function getProductionUrl(): string;

    /**
     * Get sandbox URL of service.
     *
     * @return  string
     */
    public function getSandboxUrl(): string;
}
