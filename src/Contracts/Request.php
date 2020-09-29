<?php
declare(strict_types=1);

namespace NGT\Ewus\Contracts;

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
     * @return  \NGT\Ewus\Contracts\Parser
     */
    public function getParser(): Parser;

    /**
     * The service instance.
     *
     * @return  \NGT\Ewus\Contracts\Service
     */
    public function getService(): Service;
}
