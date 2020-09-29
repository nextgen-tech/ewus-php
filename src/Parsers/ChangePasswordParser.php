<?php
declare(strict_types=1);

namespace NGT\Ewus\Parsers;

use NGT\Ewus\Contracts\Parser as ParserContract;
use NGT\Ewus\Contracts\Response;
use NGT\Ewus\Responses\ChangePasswordResponse;
use NGT\Ewus\Support\Xml;

class ChangePasswordParser extends Parser implements ParserContract
{
    public function parse(Xml $xml): Response
    {
        $xml->registerNamespace('auth');

        $response = new ChangePasswordResponse($this->request, $xml->getXml());
        $response->setChangePasswordMessage($this->parseChangePasswordMessage($xml));

        return $response;
    }

    private function parseChangePasswordMessage(Xml $xml): string
    {
        $message = $xml->get('//auth:changePasswordReturn');

        return $message->nodeValue ?? '';
    }
}
