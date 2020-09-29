<?php
declare(strict_types=1);

namespace NGT\Ewus\Parsers;

use NGT\Ewus\Contracts\Request as RequestContract;

abstract class Parser
{
    /**
     * The related request instance.
     *
     * @var  \NGT\Ewus\Contracts\Request
     */
    protected $request;

    /**
     * The parser constructor.
     *
     * @param  \NGT\Ewus\Contracts\Request  $request
     */
    public function __construct(RequestContract $request)
    {
        $this->request = $request;
    }
}
