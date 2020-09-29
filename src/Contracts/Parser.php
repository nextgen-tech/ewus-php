<?php
declare(strict_types=1);

namespace NGT\Ewus\Contracts;

use NGT\Ewus\Support\Xml;

interface Parser
{
    /**
     * Parse response XML into response.
     *
     * @param   \NGT\Ewus\Support\Xml  $xml
     * @return  \NGT\Ewus\Contracts\Response
     */
    public function parse(Xml $xml): Response;
}
