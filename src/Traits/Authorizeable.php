<?php
declare(strict_types=1);

namespace NGT\Ewus\Traits;

use InvalidArgumentException;
use NGT\Ewus\Enums\OperatorDomain;
use NGT\Ewus\Enums\OperatorType;
use NGT\Ewus\Enums\OperatorTypeKey;

trait Authorizeable
{
    /**
     * The National Health Fund (NFZ) branch code.
     *
     * @var  string
     */
    private $domain;

    /**
     * The operator login.
     *
     * @var  string
     */
    private $login;

    /**
     * The operator type code.
     *
     * @var  string|null
     */
    private $operatorType;

    /**
     * The operator identificator.
     *
     * @var  string|null
     */
    private $operatorId;

    /**
     * Set request domain.
     *
     * @param  string  $domain
     */
    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Set request login.
     *
     * @param  string  $login
     */
    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Set request operator type.
     *
     * @param  string|null  $operatorType
     */
    public function setOperatorType(?string $operatorType): self
    {
        $this->operatorType = $operatorType;

        return $this;
    }

    /**
     * Set request operator identificator.
     *
     * @param  string|null  $operatorId
     */
    public function setOperatorId(?string $operatorId): self
    {
        $this->operatorId = $operatorId;

        return $this;
    }

    /**
     * Get request domain.
     *
     * @return  string
     * @throws  InvalidArgumentException
     */
    public function getDomain(): string
    {
        if ($this->domain === null) {
            throw new InvalidArgumentException('Missing domain parameter.');
        }

        return $this->domain;
    }

    /**
     * Get request login.
     *
     * @return  string
     * @throws  InvalidArgumentException
     */
    public function getLogin(): string
    {
        if ($this->login === null) {
            throw new InvalidArgumentException('Missing login parameter.');
        }

        return $this->login;
    }

    /**
     * Get request operator type.
     *
     * @return  string|null
     * @throws  InvalidArgumentException
     */
    public function getOperatorType(): ?string
    {
        if ($this->requiresOperatorIdentificator() && $this->operatorType === null) {
            throw new InvalidArgumentException('Missing operator type parameter.');
        }

        return $this->operatorType;
    }

    /**
     * Get request operator identificator.
     *
     * @return  string|null
     * @throws  InvalidArgumentException
     */
    public function getOperatorIdentificator(): ?string
    {
        if ($this->requiresOperatorIdentificator() && $this->operatorId === null) {
            throw new InvalidArgumentException('Missing operator identificator parameter.');
        }

        return $this->operatorId;
    }

    /**
     * Envelope credentials.
     *
     * @return  array[]
     */
    private function authCredentials(): array
    {
        $credentials = [
            [
                'auth:name'  => 'domain',
                'auth:value' => [
                    'auth:stringValue' => $this->getDomain(),
                ],
            ],
            [
                'auth:name'  => 'login',
                'auth:value' => [
                    'auth:stringValue' => $this->getLogin(),
                ],
            ],
        ];

        if ($this->requiresOperatorIdentificator()) {
            $credentials[] = [
                'auth:name'  => 'type',
                'auth:value' => [
                    'auth:stringValue' => $this->getOperatorType(),
                ],
            ];

            if ($this->getOperatorIdentificator()) {
                $credentials[] = [
                    'auth:name'  => $this->operatorIdentificatorKey(),
                    'auth:value' => [
                        'auth:stringValue' => $this->getOperatorIdentificator(),
                    ],
                ];
            }
        }

        return $credentials;
    }

    /**
     * Get operator identificator key based on operator type.
     *
     * @return  string
     * @throws  InvalidArgumentException
     */
    private function operatorIdentificatorKey(): string
    {
        $operatorType = $this->getOperatorType();

        if ($operatorType === OperatorType::PROVIDER) {
            return OperatorTypeKey::PROVIDER;
        } elseif ($operatorType === OperatorType::DOCTOR) {
            return OperatorTypeKey::DOCTOR;
        }

        throw new InvalidArgumentException('Invalid operator type.');
    }

    /**
     * Check whether operator identificator is required or nor.
     *
     * @return  bool
     */
    private function requiresOperatorIdentificator(): bool
    {
        return in_array($this->getDomain(), OperatorDomain::REQUIRES_OPERATOR_ID, true);
    }
}
