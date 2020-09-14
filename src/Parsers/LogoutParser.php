<?php
declare(strict_types=1);

namespace Etermed\Ewus\Parsers;

use Etermed\Ewus\Contracts\Parser as ParserContract;
use Etermed\Ewus\Contracts\Response;
use Etermed\Ewus\Responses\LogoutResponse;
use Etermed\Ewus\Support\Xml;

class LogoutParser extends Parser implements ParserContract
{
    public function parse(Xml $xml): Response
    {
        $xml->registerNamespace('auth');

        $response = new LogoutResponse($this->request);
        $response->setLogoutMessage($this->parseLogoutMessage($xml));

        return $response;
    }

    private function parseLogoutMessage(Xml $xml): string
    {
        $message = $xml->get('//auth:logoutReturn');

        return $message->nodeValue ?? '';
    }
}
