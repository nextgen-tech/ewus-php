<?php
declare(strict_types=1);

namespace Etermed\Ewus\Responses;

use Etermed\Ewus\Contracts\Request;

abstract class Response
{
    /**
     * The related request instance.
     *
     * @var  \Etermed\Ewus\Contracts\Request
     */
    protected $request;

    /**
     * The response constructor.
     *
     * @param  \Etermed\Ewus\Contracts\Request  $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get related request.
     *
     * @return  \Etermed\Ewus\Contracts\Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
