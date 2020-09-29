<?php
declare(strict_types=1);

namespace NGT\Ewus\Requests;

use DateTimeInterface;
use InvalidArgumentException;
use NGT\Ewus\Contracts\Parser as ParserContract;
use NGT\Ewus\Contracts\Request as RequestContract;
use NGT\Ewus\Contracts\Service as ServiceContract;
use NGT\Ewus\Ewus;
use NGT\Ewus\Parsers\CheckParser;
use NGT\Ewus\Services\BrokerService;
use NGT\Ewus\Support\XmlNamespace;

class CheckRequest extends Request implements RequestContract
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
     * The PESEL of checked patient.
     *
     * @var  string
     */
    protected $pesel;

    /**
     * The logout request constructor.
     *
     * @param  string|null  $sessionId
     * @param  string|null  $token
     * @param  string|null  $pesel
     */
    public function __construct(
        string $sessionId = null,
        string $token = null,
        string $pesel = null
    ) {
        if ($sessionId !== null) {
            $this->setSessionId($sessionId);
        }

        if ($token !== null) {
            $this->setToken($token);
        }

        if ($pesel !== null) {
            $this->setPesel($pesel);
        }
    }

    /**
     * @inheritDoc
     */
    public function getParser(): ParserContract
    {
        return new CheckParser($this);
    }

    /**
     * @inheritDoc
     */
    public function getService(): ServiceContract
    {
        return new BrokerService();
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
     * Set request PESEL.
     *
     * @param  string  $pesel
     */
    public function setPesel(string $pesel): self
    {
        $this->pesel = $pesel;

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
     * Get request PESEL.
     *
     * @return  string
     * @throws  InvalidArgumentException
     */
    public function getPesel(): string
    {
        if ($this->pesel === null) {
            throw new InvalidArgumentException('Missing PESEL parameter.');
        }

        return $this->pesel;
    }

    /**
     * @inheritDoc
     */
    protected function envelopeNamespaces(): array
    {
        return array_merge(parent::envelopeNamespaces(), [
            'xmlns:com'  => XmlNamespace::get('com'),
            'xmlns:brok' => XmlNamespace::get('brok'),
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
                    'id'        => $this->getSessionId(),
                    'xmlns:ns1' => XmlNamespace::get('com'),
                ],
            ],
            'com:authToken' => [
                '_attributes' => [
                    'id'        => $this->getToken(),
                    'xmlns:ns1' => XmlNamespace::get('com'),
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
            'brok:executeService' => [
                'com:location' => [
                    'com:namespace' => 'nfz.gov.pl/ws/broker/cwu',
                    'com:localname' => 'checkCWU',
                    'com:version'   => '5.0',
                ],
                'brok:date'    => date(DateTimeInterface::RFC3339_EXTENDED),
                'brok:payload' => [
                    'brok:textload' => [
                        'ewus:status_cwu_pyt' => [
                            '_attributes' => [
                                'xmlns:ewus' => XmlNamespace::get('ewus'),
                            ],
                            'ewus:numer_pesel'  => $this->getPesel(),
                            'ewus:system_swiad' => [
                                '_attributes' => [
                                    'nazwa'  => Ewus::NAME,
                                    'wersja' => Ewus::VERSION,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
