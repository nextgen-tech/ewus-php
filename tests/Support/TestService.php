<?php

namespace Tests\Support;

use NGT\Ewus\Contracts\Service as ServiceContract;

class TestService implements ServiceContract
{
    public function getProductionUrl(): string
    {
        return 'https://xml.nextgen-tech.pl/soap?wsdl';
    }
    public function getSandboxUrl(): string
    {
        return 'https://xml.nextgen-tech.pl/soap-sandbox?wsdl';
    }
}
