<?php
declare(strict_types=1);

namespace Etermed\Ewus\Contracts;

interface Response
{
    /**
     * Get related request.
     *
     * @return  \Etermed\Ewus\Contracts\Request
     */
    public function getRequest(): Request;

    /**
     * Get raw XML data.
     *
     * @return  string
     */
    public function getXml(): string;
}
