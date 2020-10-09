<?php

namespace Tests\Support;

use NGT\Ewus\Contracts\Parser as ParserContract;
use NGT\Ewus\Parsers\Parser;

class TestParser extends Parser implements ParserContract
{
    public function parse(Xml $xml): ResponseContract
    {
        return new TestResponse($this->request, '');
    }
}
