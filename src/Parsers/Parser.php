<?php
declare(strict_types=1);

namespace Etermed\Ewus\Parsers;

use Etermed\Ewus\Contracts\Request as RequestContract;

abstract class Parser
{
    /**
     * The related request instance.
     *
     * @var  \Etermed\Ewus\Contracts\Request
     */
    protected $request;

    /**
     * The parser constructor.
     *
     * @param  \Etermed\Ewus\Contracts\Request  $request
     */
    public function __construct(RequestContract $request)
    {
        $this->request = $request;
    }
}
