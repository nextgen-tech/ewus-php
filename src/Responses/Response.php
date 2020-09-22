<?php
declare(strict_types=1);

namespace Etermed\Ewus\Responses;

use Etermed\Ewus\Contracts\Request as RequestContract;
use Etermed\Ewus\Contracts\Response as ResponseContract;

abstract class Response implements ResponseContract
{
    /**
     * The related request instance.
     *
     * @var  \Etermed\Ewus\Contracts\Request
     */
    protected $request;

    /**
     * The raw XML data.
     *
     * @var  string
     */
    protected $xml;

    /**
     * The response constructor.
     *
     * @param  \Etermed\Ewus\Contracts\Request  $request
     * @param  string                           $xml
     */
    public function __construct(RequestContract $request, string $xml)
    {
        $this->request = $request;
        $this->xml     = $xml;
    }

    /**
     * @inheritDoc
     */
    public function getRequest(): RequestContract
    {
        return $this->request;
    }

    /**
     * @inheritDoc
     */
    public function getXml(): string
    {
        return $this->xml;
    }
}
