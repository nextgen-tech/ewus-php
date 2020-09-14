<?php
declare(strict_types=1);

namespace Etermed\Ewus\Requests;

use Etermed\Ewus\Contracts\Parser as ParserContract;
use Etermed\Ewus\Contracts\Request as RequestContract;
use Etermed\Ewus\Contracts\Service as ServiceContract;
use Etermed\Ewus\Parsers\LogoutParser;
use Etermed\Ewus\Services\AuthService;
use Etermed\Ewus\Support\XmlNamespace;
use InvalidArgumentException;

class LogoutRequest extends Request implements RequestContract
{
    /**
     * The connection session identificator.
     *
     * @var  string
     */
    protected $sessionId;

    /**
     * The connection authorization token.
     *
     * @var  string
     */
    protected $token;

    /**
     * The logout request constructor.
     *
     * @param  string|null  $sessionId
     * @param  string|null  $token
     */
    public function __construct(
        string $sessionId = null,
        string $token = null
    ) {
        if ($sessionId !== null) {
            $this->setSessionId($sessionId);
        }

        if ($token !== null) {
            $this->setToken($token);
        }
    }

    /**
     * @inheritDoc
     */
    public function getParser(): ParserContract
    {
        return new LogoutParser($this);
    }

    /**
     * @inheritDoc
     */
    public function getService(): ServiceContract
    {
        return new AuthService();
    }

    /**
     * Set request session identificator.
     *
     * @param  string  $sessionId
     */
    public function setSessionId(string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Set request authorization token.
     *
     * @param  string  $token
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get request session identificator.
     *
     * @return  string
     * @throws  InvalidArgumentException
     */
    public function getSessionId(): string
    {
        if ($this->sessionId === null) {
            throw new InvalidArgumentException('Missing session identificator parameter.');
        }

        return $this->sessionId;
    }

    /**
     * Get request authorization token.
     *
     * @return  string
     * @throws  InvalidArgumentException
     */
    public function getToken(): string
    {
        if ($this->token === null) {
            throw new InvalidArgumentException('Missing authorization token parameter.');
        }

        return $this->token;
    }

    /**
     * @inheritDoc
     */
    protected function envelopeNamespaces(): array
    {
        return array_merge(parent::envelopeNamespaces(), [
            'xmlns:auth' => XmlNamespace::get('auth'),
            'xmlns:com'  => XmlNamespace::get('com'),
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function envelopeHeader(): array
    {
        return [
            'com:session' => [
                '_attributes' => [
                    'id' => $this->getSessionId(),
                ],
            ],
            'com:authToken' => [
                '_attributes' => [
                    'id' => $this->getToken(),
                ],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    protected function envelopeBody(): array
    {
        return [
            'auth:logout' => [],
        ];
    }
}
