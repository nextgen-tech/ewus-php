<?php
declare(strict_types=1);

namespace Etermed\Ewus\Contracts;

interface Response
{
    public function getRequest(): Request;
}
