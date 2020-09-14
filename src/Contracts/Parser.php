<?php
declare(strict_types=1);

namespace Etermed\Ewus\Contracts;

use Etermed\Ewus\Support\Xml;

interface Parser
{
    /**
     * Parse response XML into response.
     *
     * @param   \Etermed\Ewus\Support\Xml  $xml
     * @return  \Etermed\Ewus\Contracts\Response
     */
    public function parse(Xml $xml): Response;
}
