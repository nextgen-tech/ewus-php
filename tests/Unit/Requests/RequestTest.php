<?php
declare(strict_types=1);

namespace Tests\Unit\Requests;

use Tests\Support\TestRequest;
use Tests\TestCase;

class RequestTest extends TestCase
{
    /**
     * The request instance.
     *
     * @var  \Tests\Support\TestRequest
     */
    private $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new TestRequest();
    }

    public function testEnvelopeGeneration(): void
    {
        $xml = $this->xmlRequest('TestRequest.xml');

        $this->assertSame($xml, $this->request->toXml());
    }
}
