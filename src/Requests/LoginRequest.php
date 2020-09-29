<?php
declare(strict_types=1);

namespace NGT\Ewus\Requests;

use InvalidArgumentException;
use NGT\Ewus\Contracts\Parser as ParserContract;
use NGT\Ewus\Contracts\Request as RequestContract;
use NGT\Ewus\Contracts\Service as ServiceContract;
use NGT\Ewus\Enums\OperatorType;
use NGT\Ewus\Parsers\LoginParser;
use NGT\Ewus\Services\AuthService;
use NGT\Ewus\Support\XmlNamespace;
use NGT\Ewus\Traits\Authorizeable;

class LoginRequest extends Request implements RequestContract
{
    use Authorizeable;

    /**
     * The login request constructor.
     *
     * @param  string|null  $domain
     * @param  string|null  $login
     * @param  string|null  $password
     * @param  string|null  $operatorId
     * @param  string|null  $operatorType
     */
    public function __construct(
        string $domain = null,
        string $login = null,
        string $password = null,
        string $operatorId = null,
        string $operatorType = null
    ) {
        if ($domain !== null) {
            $this->setDomain($domain);
        }

        if ($login !== null) {
            $this->setLogin($login);
        }

        if ($password !== null) {
            $this->setPassword($password);
        }

        $this->setOperatorId($operatorId);
        $this->setOperatorType($operatorType);
    }

    /**
     * @inheritDoc
     */
    public function getParser(): ParserContract
    {
        return new LoginParser($this);
    }

    /**
     * @inheritDoc
     */
    public function getService(): ServiceContract
    {
        return new AuthService();
    }

    /**
     * Set request password.
     *
     * @param  string  $password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get request password
     *
     * @return  string
     * @throws  InvalidArgumentException
     */
    public function getPassword(): string
    {
        if ($this->password === null) {
            throw new InvalidArgumentException('Missing password parameter');
        }

        return $this->password;
    }

    /**
     * @inheritDoc
     */
    protected function envelopeNamespaces(): array
    {
        return array_merge(parent::envelopeNamespaces(), [
            'xmlns:auth' => XmlNamespace::get('auth'),
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function envelopeHeader(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    protected function envelopeBody(): array
    {
        return [
            'auth:login' => [
                'auth:credentials' => [
                    'auth:item' => $this->authCredentials(),
                ],
                'auth:password' => $this->getPassword(),
            ],
        ];
    }
}
