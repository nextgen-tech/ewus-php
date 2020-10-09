<?php

namespace Tests\Support;

use NGT\Ewus\Contracts\Parser as ParserContract;
use NGT\Ewus\Contracts\Request as RequestContract;
use NGT\Ewus\Contracts\Service as ServiceContract;
use NGT\Ewus\Requests\Request;

class TestRequest extends Request implements RequestContract
{
    public function getParser(): ParserContract
    {
        return new TestParser($this);
    }

    public function getService(): ServiceContract
    {
        return new TestService();
    }

    protected function envelopeNamespaces(): array
    {
        return array_merge(parent::envelopeNamespaces(), [
            'xmlns:ngt' => 'https://xml.nextgen-tech.pl/soap/',
        ]);
    }

    protected function envelopeHeader(): array
    {
        return [
            'ngt:test_header' => 'test_value',
        ];
    }

    protected function envelopeBody(): array
    {
        return [
            'ngt:test_body' => 'test_value',
        ];
    }
}
