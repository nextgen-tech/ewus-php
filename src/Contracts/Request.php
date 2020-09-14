<?php
declare(strict_types=1);

namespace Etermed\Ewus\Contracts;

use Exception;

interface Request
{
    /**
     * Get XML representation of request.
     *
     * @return  string
     * @throws  Exception
     */
    public function toXml(): string;

    /**
     * The response XML parser.
     *
     * @return  \Etermed\Ewus\Contracts\Parser
     */
    public function getParser(): Parser;

    /**
     * The service instance.
     *
     * @return  \Etermed\Ewus\Contracts\Service
     */
    public function getService(): Service;
}
