<?php
declare(strict_types=1);

namespace NGT\Ewus;

use NGT\Ewus\Contracts\Connection;
use NGT\Ewus\Contracts\Request;
use NGT\Ewus\Contracts\Response;
use NGT\Ewus\Exceptions\ResponseException;
use NGT\Ewus\Support\Xml;

final class Handler
{
    /**
     * The connection instance.
     *
     * @var  \NGT\Ewus\Contracts\Connection
     */
    protected $connection;

    /**
     * The sandbox mode indicator.
     *
     * @var  bool
     */
    protected $sandboxMode = false;

    /**
     * The handler constructor.
     *
     * @param  \NGT\Ewus\Contracts\Connection|null  $connection
     * @param  bool $sandboxMode
     */
    public function __construct(Connection $connection = null, bool $sandboxMode = false)
    {
        if ($connection !== null) {
            $this->setConnection($connection);
        }

        if ($sandboxMode === true) {
            $this->enableSandboxMode();
        }
    }

    /**
     * Set handler to sandbox mode.
     *
     * @return self
     */
    public function enableSandboxMode()
    {
        $this->sandboxMode = true;

        return $this;
    }

    /**
     * Set connection for handler.
     *
     * @param  \NGT\Ewus\Contracts\Connection  $connection
     * @return self
     */
    public function setConnection(Connection $connection): self
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Handle request and turn it into response.
     *
     * @param   \NGT\Ewus\Contracts\Request  $request
     * @return  \NGT\Ewus\Contracts\Response
     * @throws  \NGT\Ewus\Exceptions\ResponseException
     */
    public function handle(Request $request): Response
    {
        $response = $this->send($request);

        if ($response->hasError()) {
            throw ResponseException::fromXml($response);
        }

        return $request->getParser()->parse($response);
    }

    /**
     * Send request.
     *
     * @param   \NGT\Ewus\Contracts\Request  $request
     * @return  \NGT\Ewus\Support\Xml
     */
    protected function send(Request $request): Xml
    {
        $response = $this->connection
            ->setService($request->getService())
            ->setSandboxMode($this->sandboxMode)
            ->send($request->toXml());

        return new Xml($response);
    }
}
