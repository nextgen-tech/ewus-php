<?php
declare(strict_types=1);

namespace Etermed\Ewus\Parsers;

use Etermed\Ewus\Contracts\Parser as ParserContract;
use Etermed\Ewus\Contracts\Response;
use Etermed\Ewus\Responses\ChangePasswordResponse;
use Etermed\Ewus\Support\Xml;

class ChangePasswordParser extends Parser implements ParserContract
{
    public function parse(Xml $xml): Response
    {
        $xml->registerNamespace('auth');

        $response = new ChangePasswordResponse($this->request);
        $response->setChangePasswordMessage($this->parseChangePasswordMessage($xml));

        return $response;
    }

    private function parseChangePasswordMessage(Xml $xml): string
    {
        $message = $xml->get('//auth:changePasswordReturn');

        return $message->nodeValue ?? '';
    }
}
