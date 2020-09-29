<?php
declare(strict_types=1);

namespace NGT\Ewus\Requests;

use NGT\Ewus\Contracts\Request as RequestContract;
use Spatie\ArrayToXml\ArrayToXml;

abstract class Request implements RequestContract
{
    /**
     * SOAP envelope namespaces.
     *
     * @return  string[]
     */
    protected function envelopeNamespaces(): array
    {
        return [
            'xmlns:soapenv' => 'http://schemas.xmlsoap.org/soap/envelope/',
        ];
    }

    /**
     * SOAP envelope header.
     *
     * @return  mixed[]
     */
    abstract protected function envelopeHeader(): array;

    /**
     * SOAP envelope body.
     *
     * @return  mixed[]
     */
    abstract protected function envelopeBody(): array;

    /**
     * SOAP envelope.
     *
     * @return  array[]
     */
    protected function envelope(): array
    {
        return [
            'soapenv:Header' => $this->envelopeHeader(),
            'soapenv:Body'   => $this->envelopeBody(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function toXml(): string
    {
        $xml = new ArrayToXml($this->envelope(), [
            'rootElementName' => 'soapenv:Envelope',
            '_attributes'     => $this->envelopeNamespaces(),
        ]);

        return $xml->dropXmlDeclaration()->prettify()->toXml();
    }
}
