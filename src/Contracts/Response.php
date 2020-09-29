<?php
declare(strict_types=1);

namespace NGT\Ewus\Contracts;

interface Response
{
    /**
     * Get related request.
     *
     * @return  \NGT\Ewus\Contracts\Request
     */
    public function getRequest(): Request;

    /**
     * Get raw XML data.
     *
     * @return  string
     */
    public function getXml(): string;
}
