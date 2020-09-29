<?php
declare(strict_types=1);

namespace NGT\Ewus\Parsers;

use NGT\Ewus\Contracts\Parser as ParserContract;
use NGT\Ewus\Contracts\Response;
use NGT\Ewus\Responses\LogoutResponse;
use NGT\Ewus\Support\Xml;

class LogoutParser extends Parser implements ParserContract
{
    public function parse(Xml $xml): Response
    {
        $xml->registerNamespace('auth');

        $response = new LogoutResponse($this->request, $xml->getXml());
        $response->setLogoutMessage($this->parseLogoutMessage($xml));

        return $response;
    }

    private function parseLogoutMessage(Xml $xml): string
    {
        $message = $xml->get('//auth:logoutReturn');

        return $message->nodeValue ?? '';
    }
}
